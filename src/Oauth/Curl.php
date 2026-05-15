<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\Oauth;

use TamasVarga\LuandaPHP\Misc\IncidentReporter;

/**
 * Minimal cURL abstraction layer.
 * Stores all configuration as internal state and applies it as a single
 * batch in exec(), ensuring a predictable and consistent request state.
 * Subclasses configure via protected setters; external callers only call exec().
 */
class Curl {
	/** Populated after exec() — null until first execution */
	public ?CurlResponse $response      = null;
	
	/** @var \CurlHandle|null Active cURL handle, nulled after exec() or on init failure */
	protected ?\CurlHandle $curlHandle  = null;
	
	// Connection
	protected ?int $port                = null;
	protected int $connectTimeout       = 10;
	protected int $timeout              = 30;
	protected int $maxRedirs            = 5;
	protected bool $followLocation      = false;
	protected bool $returnTransfer      = true;
	
	// Request
	protected bool $post                = false;
	protected ?string $url              = null;
	protected ?string $customRequest    = null;
	protected ?string $userAgent        = null;
	protected array $postFields         = [];
	protected array $httpHeaders        = [];
	
	// Auth
	/** Stored as user:password after setUser() */
	protected ?string $user             = null;
	protected int $httpAuth             = curl_auth_types::BASIC;
	
	// SSL
	protected bool $sslVerifyPeer       = true;
	/** See ssl_verify_modes — 0: none, 1: relaxed, 2: strict */
	protected int $sslVerifyHost        = ssl_verify_modes::STRICT;
	protected ?string $caInfo           = null;
	
	// Response
	protected bool $includeHeader       = false;
	
	/**
	 * @param string $url Target URL for the request
	 */
	public function __construct(string $url) {
		$this->setTargetUrl($url);
		
		if (!extension_loaded('curl')) {
			if (IncidentReporter::isAvailable()) IncidentReporter::report('Curl::init', 'curl extension missing');
		} elseif (!$this->curlHandle = curl_init()) {
			if (IncidentReporter::isAvailable()) IncidentReporter::report('Curl::init', 'curl_init() failed');
		} else {
			$this->response = new CurlResponse();
		}
	}
	
	// -------------------------------------------------------------------------
	// Connection
	// -------------------------------------------------------------------------
	
	/** @param int $port Override default port */
	public function setPort(int $port): void {
		$this->port = $port;
	}
	
	/** @param string $url Retarget the request URL — can be called before exec() */
	public function setTargetUrl(string $url): void {
		$this->url = $url;
	}
	
	/** @param int $seconds Timeout for establishing the connection */
	public function setConnectTimeout(int $seconds): void {
		$this->connectTimeout = $seconds;
	}
	
	/** @param int $seconds Timeout for the entire request */
	public function setTimeout(int $seconds): void {
		$this->timeout = $seconds;
	}
	
	/**
	 * Whether to return the response body as a string.
	 * Almost always true — only set false if you're streaming output directly.
	 * @param bool $returnTransfer
	 */
	public function wantReturnTransfer(bool $returnTransfer): void {
		$this->returnTransfer = $returnTransfer;
	}
	
	/** @param bool $follow Whether to automatically follow Location headers */
	public function followLocation(bool $follow): void {
		$this->followLocation = $follow;
	}
	
	/** @param int $max Maximum number of redirects to follow */
	public function setMaxRedirs(int $max): void {
		$this->maxRedirs = $max;
	}
	
	// -------------------------------------------------------------------------
	// Request
	// -------------------------------------------------------------------------
	
	/** @param bool $post True for POST, false for GET */
	public function setPost(bool $post): void {
		$this->post = $post;
	}
	
	/**
	 * POST body fields. Passed as array; if a single entry is present it will
	 * be extracted as a plain string by applyOptions() to avoid multipart encoding.
	 * @param array $fields
	 */
	public function setPostFields(array $fields): void {
		$this->postFields = $fields;
	}
	
	/**
	 * Override the HTTP method — use for PUT, PATCH, DELETE etc.
	 * @param string $method HTTP verb in uppercase
	 */
	public function setCustomRequest(string $method): void {
		$this->customRequest = $method;
	}
	
	/**
	 * @param array $headers Raw header strings e.g. ['Authorization: Bearer token', 'Accept: application/json']
	 */
	public function setHttpHeaders(array $headers): void {
		$this->httpHeaders = $headers;
	}
	
	/** @param string $userAgent User-Agent header value */
	public function setUserAgent(string $userAgent): void {
		$this->userAgent = $userAgent;
	}
	
	// -------------------------------------------------------------------------
	// Auth
	// -------------------------------------------------------------------------
	
	/**
	 * Sets HTTP basic (or other) auth credentials.
	 * Stored internally as user:password string.
	 * @param string $user
	 * @param string $password
	 */
	public function setUser(string $user, string $password): void {
		$this->user = $user . ':' . $password;
	}
	
	/**
	 * @param int $authType One of curl_auth_types constants
	 */
	public function setHttpAuth(int $authType): void {
		$this->httpAuth = $authType;
	}
	
	// -------------------------------------------------------------------------
	// SSL
	// -------------------------------------------------------------------------
	
	/**
	 * Whether to verify the server's SSL certificate against trusted CAs.
	 * Never disable in production — turning this off allows MITM attacks.
	 * @param bool $verify
	 */
	public function setSslVerifyPeer(bool $verify): void {
		$this->sslVerifyPeer = $verify;
	}
	
	/**
	 * @param int $verify One of ssl_verify_modes constants.
	 *                    RELAXED (1) is useful for hosts with root-only certs e.g. some Cloudflare setups.
	 */
	public function setSslVerifyHost(int $verify): void {
		$this->sslVerifyHost = $verify;
	}
	
	/** @param string $path Absolute path to CA bundle file */
	public function setCaInfo(string $path): void {
		$this->caInfo = $path;
	}
	
	// -------------------------------------------------------------------------
	// Response
	// -------------------------------------------------------------------------
	
	/**
	 * Whether to include response headers in the output string.
	 * If true, response content will contain headers prepended to the body.
	 * @param bool $include
	 */
	public function setIncludeHeader(bool $include): void {
		$this->includeHeader = $include;
	}
	
	// -------------------------------------------------------------------------
	// Internals
	// -------------------------------------------------------------------------
	
	/**
	 * Applies all stored options to the cURL handle in one batch.
	 * Called exclusively by exec() — never call directly.
	 * Nullable options are only applied if set, to avoid overriding cURL defaults with null.
	 */
	private function applyOptions(): void {
		if ($this->port)            curl_setopt($this->curlHandle, CURLOPT_PORT, $this->port);
		if ($this->userAgent)       curl_setopt($this->curlHandle, CURLOPT_USERAGENT, $this->userAgent);
		if ($this->customRequest)   curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, $this->customRequest);
		if ($this->httpHeaders)     curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, $this->httpHeaders);
		if ($this->user)            curl_setopt($this->curlHandle, CURLOPT_USERPWD, $this->user);
		if ($this->caInfo)          curl_setopt($this->curlHandle, CURLOPT_CAINFO, $this->caInfo);
		
		if ($this->postFields) {
			$_fields = count($this->postFields) === 1 ? reset($this->postFields) : $this->postFields;
			curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $_fields);
		}
		
		curl_setopt($this->curlHandle, CURLOPT_URL, $this->url);
		curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, $this->returnTransfer);
		curl_setopt($this->curlHandle, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
		curl_setopt($this->curlHandle, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($this->curlHandle, CURLOPT_FOLLOWLOCATION, $this->followLocation);
		curl_setopt($this->curlHandle, CURLOPT_MAXREDIRS, $this->maxRedirs);
		curl_setopt($this->curlHandle, CURLOPT_POST, $this->post);
		curl_setopt($this->curlHandle, CURLOPT_HTTPAUTH, $this->httpAuth);
		curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYPEER, $this->sslVerifyPeer);
		curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYHOST, $this->sslVerifyHost);
		curl_setopt($this->curlHandle, CURLOPT_HEADER, $this->includeHeader);
	}
	
	/**
	 * Applies all options, executes the request, populates $this->response and returns it.
	 * Closes and nulls the handle after execution — the instance is not reusable after exec().
	 * @return CurlResponse
	 */
	public function exec(): CurlResponse {
		if ($this->curlHandle) {
			$this->applyOptions();
			
			$_result = curl_exec($this->curlHandle);
			
			if ($_result === false) {
				$this->response->success = false;
				$this->response->error   = curl_error($this->curlHandle);
				if (IncidentReporter::isAvailable()) IncidentReporter::report('Curl::exec', 'CURL exec failed: ' . $this->response->error);
			} else {
				$this->response->success  = true;
				$this->response->content  = $_result;
				$this->response->httpCode = curl_getinfo($this->curlHandle, curl_info::HTTP_CODE);
			}
			
			curl_close($this->curlHandle);
			$this->curlHandle = null;
		} else {
			$this->response->error = 'No open CURL handle';
			if (IncidentReporter::isAvailable()) IncidentReporter::report('Curl::exec', 'No open CURL handle');
		}
		
		return $this->response;
	}
}

/**
 * Value object populated by Curl::exec().
 * Never instantiated directly — always accessed via Curl::$response after exec().
 */
class CurlResponse {
	public bool $success        = false;
	public int $httpCode        = 0;
	public string $content      = '';
	public string $error        = '';
}

/** cURL HTTP authentication method constants */
class curl_auth_types {
	public const BASIC      = CURLAUTH_BASIC;       // user:pass base64 encoded header
	public const DIGEST     = CURLAUTH_DIGEST;      // MD5 challenge-response, more secure than basic
	public const DIGEST_IE  = CURLAUTH_DIGEST_IE;   // digest with IE quirks for legacy compat
	public const BEARER     = CURLAUTH_BEARER;      // OAuth2 bearer token
	public const NEGOTIATE  = CURLAUTH_NEGOTIATE;   // Kerberos/SPNEGO, enterprise SSO
	public const NTLM       = CURLAUTH_NTLM;        // Windows NTLM, legacy Microsoft
	public const NTLM_WB    = CURLAUTH_NTLM_WB;     // NTLM delegated to winbind helper
	public const AWS_SIGV4  = CURLAUTH_AWS_SIGV4;   // AWS signature v4
	public const ANY        = CURLAUTH_ANY;         // let curl pick from any method
	public const ANYSAFE    = CURLAUTH_ANYSAFE;     // let curl pick, excluding basic
	public const ONLY       = CURLAUTH_ONLY;        // mask flag — force single method only
}

/**
 * SSL host verification level constants for CURLOPT_SSL_VERIFYHOST.
 * Note: RELAXED (1) is technically deprecated by libcurl but remains
 * the only sane option for hosts with root-only certificates.
 */
class ssl_verify_modes {
	public const NONE       = 0;    // no hostname check
	public const RELAXED    = 1;    // cert must exist, hostname match not enforced
	public const STRICT     = 2;    // cert must match hostname exactly or via wildcard
}

/** CURLINFO_* constants for use with curl_getinfo() */
class curl_info {
	// Response
	public const HTTP_CODE                  = CURLINFO_HTTP_CODE;               // int — last received HTTP code
	public const RESPONSE_CODE              = CURLINFO_RESPONSE_CODE;           // int — alias of HTTP_CODE
	public const CONTENT_TYPE               = CURLINFO_CONTENT_TYPE;            // string — content-type of downloaded object
	public const REDIRECT_COUNT             = CURLINFO_REDIRECT_COUNT;          // int — number of redirects followed
	public const REDIRECT_URL               = CURLINFO_REDIRECT_URL;            // string — URL of next redirect (if not followed)
	
	// Timing (floats, seconds)
	public const TOTAL_TIME                 = CURLINFO_TOTAL_TIME;              // total transaction time
	public const NAMELOOKUP_TIME            = CURLINFO_NAMELOOKUP_TIME;         // DNS resolution time
	public const CONNECT_TIME               = CURLINFO_CONNECT_TIME;            // time to establish connection
	public const PRETRANSFER_TIME           = CURLINFO_PRETRANSFER_TIME;        // time from start to just before transfer
	public const STARTTRANSFER_TIME         = CURLINFO_STARTTRANSFER_TIME;      // time to first byte
	public const REDIRECT_TIME              = CURLINFO_REDIRECT_TIME;           // time for all redirects
	
	// Size (floats, bytes)
	public const SIZE_DOWNLOAD              = CURLINFO_SIZE_DOWNLOAD;           // bytes downloaded
	public const SIZE_UPLOAD                = CURLINFO_SIZE_UPLOAD;             // bytes uploaded
	public const HEADER_SIZE                = CURLINFO_HEADER_SIZE;             // bytes of response headers
	public const REQUEST_SIZE               = CURLINFO_REQUEST_SIZE;            // bytes of sent request
	public const CONTENT_LENGTH_DOWNLOAD    = CURLINFO_CONTENT_LENGTH_DOWNLOAD; // content-length of download, -1 if unknown
	public const CONTENT_LENGTH_UPLOAD      = CURLINFO_CONTENT_LENGTH_UPLOAD;   // content-length of upload, -1 if unknown
	
	// Speed (floats, bytes/sec)
	public const SPEED_DOWNLOAD             = CURLINFO_SPEED_DOWNLOAD;          // average download speed
	public const SPEED_UPLOAD               = CURLINFO_SPEED_UPLOAD;            // average upload speed
	
	// Connection
	public const PRIMARY_IP                 = CURLINFO_PRIMARY_IP;              // string — IP of last connection
	public const PRIMARY_PORT               = CURLINFO_PRIMARY_PORT;            // int — port of last connection
	public const LOCAL_IP                   = CURLINFO_LOCAL_IP;                // string — local IP of last connection
	public const LOCAL_PORT                 = CURLINFO_LOCAL_PORT;              // int — local port of last connection
	
	// SSL
	public const CERTINFO                   = CURLINFO_CERTINFO;                // array — certificate chain info
	public const SSL_VERIFYRESULT           = CURLINFO_SSL_VERIFYRESULT;        // int — SSL cert verification result code
	
	// Misc
	public const EFFECTIVE_URL              = CURLINFO_EFFECTIVE_URL;           // string — last used URL (after redirects)
	public const EFFECTIVE_METHOD           = CURLINFO_EFFECTIVE_METHOD;        // string — last used HTTP method
	public const PRIVATE                    = CURLINFO_PRIVATE;                 // string — private data attached to handle
}

?>