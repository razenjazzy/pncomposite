<?php
/*
Plugin Name: Page View
Plugin URI: http://urbangiraffe.com/plugins/pageview/
Description: Allows the insertion of code to display an external webpage within an iframe, along with a title and description.  The tag to insert the code is: <code>[pageview url="url" title="title"]</code>
Version: 1.6
Author: John Godley
Author URI: http://urbangiraffe.com
*/

class PageView {
	public function __construct() {
		add_shortcode( 'pageview', array( &$this, 'shortcode' ) );
	}

	private function render( $url, $title, $desc, $width, $height, $border, $scroll ) {
		$width  = preg_replace( '/[^0-9%px]/', '', $width );
		$height = preg_replace( '/[^0-9%px]/', '', $height );

		$border = ( $border == 'yes' ) ? 'border: 1px solid #999' : '';

		if ( !in_array( $scroll, array( 'auto', 'yes', 'no' ) ) )
			$scroll = 'no';

		ob_start();
?>
<div class="pageview">
	<?php if ( $title || $desc ) : ?>
	  <table class="pageviewhead" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 0px">

			<?php if ( $title ) : ?>
				<tr>
		      <td width="80"><strong><?php _e( 'Title' ); ?>:</strong></td>
		      <td><a title="View fullscreen" target="_blank" href="<?php echo esc_url( $url ) ?>"><?php echo esc_html( $title ) ?></a></td>
				</tr>
			<?php endif; ?>

			<?php if ( $desc ) : ?>
		  	<tr>
			    <td width="80" valign="top"><strong><?php _e( 'Description' ); ?>:</strong></td>
		      <td><?php echo esc_html( $desc ) ?></td>
				</tr>
			<?php endif; ?>

	  </table>
	<?php endif; ?>

  <iframe src="<?php echo esc_url( $url ) ?>" frameborder="0" style="<?php echo esc_attr( $border ); ?>" scrolling="<?php echo esc_attr( $scroll ); ?>" height="<?php echo esc_attr( $height ); ?>" width="<?php echo esc_attr( $width ); ?>">Get a better browser!</iframe>
</div>
<?php
		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	public function shortcode( $attrs, $content = null, $code = '' ) {
		$title  = $desc = $url = '';
		$height = '400px';
		$width  = '100%';
		$border = 'no';
		$scrolling = 'no';

		if ( isset( $attrs['url'] ) ) {
			// New style
			foreach ( array( 'url', 'title', 'desc', 'height', 'width', 'border', 'scrolling' ) AS $attr ) {
				if ( isset( $attrs[$attr] ) )
					$$attr = $attrs[$attr];
			}
		}
		else {
			// Old style
			$url   = $attrs[0];
			$title = $desc = '';

			if ( isset( $attrs[1] ) )
				$title = $attrs[1];

			if ( count( $attrs ) > 2 )
				$desc = implode( ' ', array_slice( $attrs, 2 ) );
		}

		if ( $url )
			return $this->render( $url, $title, $desc, $width, $height, $border, $scrolling );
		return '';
	}
}

function register_pageview() {
	global $pageview;

	$pageview = new PageView();
}

add_action( 'init', 'register_pageview' );

