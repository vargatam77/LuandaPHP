<?php
declare(strict_types=1);

namespace TamasVarga\LuandaPHP\Misc;

/**
 * Represents an encoded image (<img>) element with various attributes.
 */
class EncodedImg {
	protected ?string $src = null; // Source attribute
	
	/**
	 * Constructor for the EncodedImg element.
	 *
	 * @param string|null $src The source path of the image
	 */
	public function __construct(?string $src = null) {
		if ($src) $this->src = $src;
	}
	
	/**
	 * Formats raw binary data into a Base64 Data URI.
	 *
	 * @param string $data      The raw binary data
	 * @param string $mime_type The MIME type of the image (e.g., 'image/png')
	 * @return string The formatted Data URI
	 */
	private function encodeBase64(string $data, string $mimetype = 'image/png'): string {
		$_base64 = base64_encode($data);
		$_uri = 'data:' . $mimetype . ';base64,' . $_base64;
		
		return $_uri;
	}
	
	/**
	 * Loads a local file and converts it to a Base64 Data URI.
	 * If no source is set or the file does not exist, a default
	 * no-image placeholder SVG is generated and encoded instead.
	 *
	 * @return string Base64 Data URI or default placeholder on failure
	 */
	public function loadToBase64(): string {
		$_data = '';
		$_mime = '';
		
		if ($this->src && file_exists($this->src) && $_data = file_get_contents($this->src)) {
			$_mime = mime_content_type($this->src) ?: 'image/png';
		} else {
			$_default_img = new Svg();
			$_data = $_default_img->createDefaultImage();
			$_mime = 'image/svg+xml';
		}
		
		return $this->encodeBase64($_data, $_mime);
	}
}

?>