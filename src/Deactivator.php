<?php
namespace Tanvir10\Plugin;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @package Plugin
 * @subpackage Deactivator
 * @author Tanvir10 <hi@tanvir10.io>
 */
class Deactivator extends Base {

	public $slug;
	
	public $name;
	
	public $server;
	
	public function __construct( $plugin ) {
		$this->plugin 	= $plugin;
		$this->server 	= $this->plugin['server'];
		$this->slug 	= $this->plugin['TextDomain'];
		$this->name 	= $this->plugin['Name'];
		
		self::hooks();
	}

	function hooks() {

		$this->action( 'admin_footer', 'deactivation_survey_modal', 99 );

		if( did_action( 'tan-plugin-deactivation' ) ) return;
		do_action( 'tan-plugin-deactivation' );

		$this->action( 'admin_enqueue_scripts', 'enqueue_scripts', 99 );
		$this->priv( 'tan-plugin-deactivation', 'send_deactivation_survey', 99 );
	}

	public function enqueue_scripts( $screen ) {
		if ( get_current_screen()->base != 'plugins' )return;

        wp_enqueue_style( "tan-plugin-deactivator", plugins_url( 'assets/css/deactivator.css', __FILE__ ), [], '' );
        wp_enqueue_script( "tan-plugin-deactivator", plugins_url( 'assets/js/deactivator.js', __FILE__ ), [ 'jquery' ], '', true );
    }

	public function deactivation_survey_modal()	{
		if ( get_current_screen()->base != 'plugins' ) return;
		?>
		<script type="text/javascript">
			jQuery(function($){
				$(document).on( 'click', 'tr[data-slug="<?php echo $this->slug; ?>"] .deactivate a', function(e){
					e.preventDefault()
					$('.tan-plugin-deactivation-survey-overlay').css('display', 'flex');
					$('.tan-plugin-dsm-skip-btn').prop('href', $(this).attr('href'));
					$('#tand-plugin-name').val( "<?php echo $this->slug; ?>" );
				} )
			})
		</script>
		<?php

		if( did_action( 'tan-plugin-deactivation-modal' ) ) return;
		do_action( 'tan-plugin-deactivation-modal' );
		
		$user = wp_get_current_user();
		?>
		<div class="tan-plugin-deactivation-survey-overlay">
			<div class="tan-plugin-deactivation-survey-modal">
				<div class="tan-plugin-deactivation-survey-form">
					<form method="post" class="tan-plugin-deactivation-survey-form">
						<input type="hidden" name="first_name" value="<?php echo $user->first_name ?>">
						<input type="hidden" name="last_name" value="<?php echo $user->last_name ?>">
						<input type="hidden" name="user_email" value="<?php echo $user->user_email ?>">
						<input type="hidden" name="plugin" value="" id="tand-plugin-name">
						<input type="hidden" name="site_url" value="<?php echo site_url( '/' ) ?>">
						<input type="hidden" name="action" value="tan-plugin-deactivation">
						<div class="tan-plugin-dsm-header">
							<h3 class="tan-heading">
								<?php printf( __( 'We\'re so sorry to see you go, %s!', 'tanvir10' ), $user->display_name ); ?>
							</h3>
							<p class="tan-heading"><?php _e( 'Would you mind telling us why you are deactivating so we can improve it? 🤔', 'tanvir10' ) ?></p>
						</div>
						<div class="tan-plugin-dsm-body">
							<div class="tan-plugin-deactivation-reasons">
								<?php
								foreach ( $this->get_reasons() as $key => $label ) {
									echo "
									<div class='tan-plugin-deactivation-reason'>
										<label for='{$key}'>{$label}</label>
										<input type='checkbox' name='reason[]' value='{$key}' id='{$key}'>
									</div>
									";
								}
								?>
							</div>
							<div class="tan-plugin-dsm-reason-details">
								<textarea class="tan-plugin-dsm-reason-details-input" name="explanation" rows="5" placeholder="Please Explain"></textarea>
							</div>
						</div>
						<div class="tan-plugin-dsm-footer">
							<a href="" class="button tan-plugin-dsm-skip-btn"><?php _e( 'Skip & Deactivate', 'tanvir10' ) ?></a>
							<div class="tan-plugin-dsm-submit">
								<button class="button tan-plugin-dsm-btn tan-plugin-dsm-close"><?php _e( 'Cancel', 'tanvir10' ) ?></button>
								&nbsp;
								<button class="button button-primary tan-plugin-dsm-btn tan-plugin-dsm-submit" type="submit"><?php _e( 'Submit & Deactivate', 'tanvir10' ) ?></button>
							</div>
						</div>
					</form>
				</div>
				<div class="tan-plugin-deactivation-survey-img">
					<p class="tan-desc tan-consent-label" data-desc="<?php _e( 'It includes your name, email, site URL and the input you give here.', 'tanvir10' ); ?>"><?php _e( 'What data we collect', 'tanvir10' ); ?></p>
					<img src="<?php echo plugins_url( 'assets/img/sorry.webp', __FILE__ ); ?>">

				</div>
			</div>
		</div>
		<?php
	}

	public function send_deactivation_survey()	{
		// deactivate the plugin first
		deactivate_plugins( "{$this->slug}/{$this->slug}.php" );

		// send data
		$url = add_query_arg( [ 
		    'rest_route'    => '/plugins/deactivation',
		    'first_name'    => $_POST['first_name'],
		    'last_name'     => $_POST['last_name'],
		    'email'     	=> $_POST['user_email'],
		    'plugin'     	=> $_POST['plugin'],
		    'site_url'     	=> $_POST['site_url'],
		    'reason'     	=> serialize( $_POST['reason'] ),
		    'explanation'	=> $_POST['explanation'],
		], wp_unslash( $this->server ) );

		wp_remote_get( $url );

		wp_send_json( [ 'status' => 1, 'message' => __( 'Plugin deactivated' ) ] );
	}

	public function get_reasons() {
		$reasons = [
			'temporary'				=> 'It\'s a temporary deactivation',
			'found_better'			=> 'Found a better plugin',
			'features_missing'		=> 'Important features missing',
			'doesnt_working'		=> 'It doesn\'t work as expected',
			'mistakenly_installed'	=> 'I had installed it by mistake',
			'others'				=> 'Others',
		];

		return apply_filters( "tan-plugin-deactivation-reasons", $reasons, $this->slug );
	}
}