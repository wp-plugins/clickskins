<?php

/*

 * @class 		SnapycodeFlake

 * @package		snapycode_flake

 * @category	Class

 * @author		SnapyCode

 */

class SnapycodeFlake {

	var $_cache;

	var $errors = array(); // Stores store errors

	var $messages = array(); // Stores store messages

	var $plugin_url;

	var $plugin_path;

	var $inline_js = '';

	public function __construct() {

		$this->plugin_url = $this->plugin_url();

		if( is_admin() ){

			$this->include_scripts();

			//Adding all neccessory css and js
			if(isset($_GET['page'])){
				$page_param = $_GET['page'];
				
				if(strpos($page_param,'ghostskin') !== false){
					
					wp_enqueue_style('spc_message_css', $this->plugin_url() . '/assets/css/message.css');					
					wp_enqueue_script('spc_admin_js', $this->plugin_url() . '/assets/js/snapycode_flake_admin.js', array( 'jquery' ), '', true);
				}
				
			}
			
		}

	}

/*

	 * Get the plugin url

	 */

	public function plugin_url() { 

		if($this->plugin_url) return $this->plugin_url;

		if (is_ssl()) :

			return $this->plugin_url = str_replace('http://', 'https://', WP_PLUGIN_URL) . "/" . plugin_basename( dirname(dirname(__FILE__))); 

		else :

			return $this->plugin_url = WP_PLUGIN_URL . "/" . plugin_basename( dirname(dirname(__FILE__))); 

		endif;

	}

/*

	 * Get the plugin dir

	 */

	public function plugin_dir()

	{

		$dir = plugin_dir_path( __FILE__ );	

		$dir = str_replace("classes/", "", $dir);

		return $dir;

	}

	/*

	 * Get the plugin path

	 */

	public function plugin_path() { 	

		if($this->plugin_path) return $this->plugin_path;

		return $this->plugin_path = WP_PLUGIN_DIR . "/" . plugin_basename( dirname(dirname(__FILE__))); 

	 }

	/*

	 * Function to include scripts

	 */

	public function include_scripts()

	{

		$pluginfolder = $this->plugin_url() . '/assets/';

		wp_enqueue_script('jquery');

		wp_enqueue_script('jquery-ui-core');

		wp_enqueue_script('jquery-ui-tabs');

		wp_enqueue_script("jquery-effects-core");

		wp_enqueue_script('jquery-ui-datepicker');
		//wp_enqueue_script('thickbox');

		//wp_enqueue_style('thickbox');

	}

	/*

	* Function for redirect

	*/

	public function readirect_me($page_id=false, $refresh=false, $param='')

	{

		$page_id = (int)$page_id;

		//If page id is not provided then redirect to home page.

		if($refresh == true)

		{

			$redirect_url = $this->full_url();

		}

		elseif( $page_id == false || $page_id == 0 || $page_id== '0' )

		{

			$redirect_url = get_bloginfo('wpurl');

		}else{

			$redirect_url = get_page_link($page_id);

		}

		//check if ssl on.

		if (is_ssl())

		{

			if( stripos( $redirect_url, 'https://') === false )

			{

				$redirect_url = str_replace("http", "https", $redirect_url);	

			}

		}

		//Check if qtranslator exist

		if( function_exists('qtrans_convertURL') )

		{

			$redirect_url = qtrans_convertURL( $redirect_url );

		}

		//Adding param to the url

		$redirect_url = $redirect_url.$param;

		//Now redirect

		wp_redirect( $redirect_url, 301 ); exit;

	}

	/*

	* Function to get url

	*/

	public function get_url($page_id=false, $param='')

	{

		$page_id = (int)$page_id;

		//If page id is not provided then redirect to home page.

		if( $page_id == false || $page_id == 0 || $page_id== '0' )

		{

			$page_url = get_bloginfo('wpurl');

		}else{

			$page_url = get_page_link($page_id);

		}

		//check if ssl on.

		if (is_ssl())

		{

			if( stripos( $page_url, 'https://') === false )

			{

			$page_url = str_replace("http", "https", $page_url);	

			}

		}

		//Check if qtranslator exist

		if( function_exists('qtrans_convertURL') )

		{

			$page_url = qtrans_convertURL( $page_url );

		}

		//Adding param to the url

		$page_url = $page_url.$param;

	//Now redirect

		return $page_url;

	}

	/*

	 * Function to get current full url

     * @param $remove if provided that string and after that any number will be removed.

     */

    public function full_url($remove='') {

        $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";

        $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);

        $protocol = substr($sp, 0, strpos($sp, "/")) . $s;

        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);

        $url = $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];

	   if ($remove != '') {

            //$url = preg_replace("/{$remove}\d+/", '', $url);

            $url = str_replace("$remove", '', $url);

        }

        return $url;

    }

	/*

	 * Function to strip any string

     * @param $charlength charecter length, $content string to be strip.

     */

	public function stripe_content($charlength, $content) {

		$excerpt = $content;

		$charlength++;

		if ( mb_strlen( $excerpt ) > $charlength ) {

			$subex = mb_substr( $excerpt, 0, $charlength - 5 );

			$exwords = explode( ' ', $subex );

			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );

			if ( $excut < 0 ) {

				return mb_substr( $subex, 0, $excut );

			} else {

				return $subex;

			}

		} else {

			return $excerpt;

		}

	}

	/*

	* Function to set message.

	*/

	public function set_message($message='', $type='info')

	{

		$msg_class = 'isa_info';

		switch($type)

		{

			case 'success':

				$msg_class = 'isa_success';

			break;

			case 'error':

				$msg_class = 'isa_error';

			break;			

			case 'info':

				$msg_class = 'isa_info';

			break;				

			case 'warning':

				$msg_class = 'isa_warning';

			break;

		}

		$_SESSION['spc_message'] = '<div class="'.$msg_class.'">'.$message.'</div>';

	}

	/*

	* Function to show message.

	*/

	public function show_message()

	{

		if( isset($_SESSION['spc_message']) && !empty($_SESSION['spc_message']) )

		{

			echo '<div id="message" class="updated below-h2" style="padding: 13px 12px;"><strong>'.$_SESSION['spc_message'].'</div>';
		}

	}

	/*

	* Admin Header

	*/

	public function admin_head()

	{

		?>
        <div id="notify_scroll"></div>
        <div id="spc_notifications">
          <?php $this->show_message(); ?>
        </div>
		<?php

	}
	
	/*
	* Admin Header
	*/	
	public function getFlakeMusic($only_state=false)
	{
		
		global $wpdb;

		$data_query = "SELECT * FROM {$wpdb->prefix}spc_flakes where flake_music_enable = '1'";
		$rows = $wpdb->get_results( $data_query, OBJECT ); 
		$data = '';
		$music = get_option( 'ghostskin_flake_music', '' );
		$i = 1;
		
		if( trim($music) != '' && count($rows) > 0)
		{
			$musics = explode(",", trim($music));
			if( is_array($musics) && (count($musics) > 0 ) )
			{
				//send confirmation that bg music is on.
				if( $only_state==true){ return true; }
				
				$data = '<ul class="playlist" style="display:none;">';
				
				foreach($musics as $m){
					if( ''!= trim($m) ){
						$data .= '<li><a href="'.trim($m).'">spc_'.$i.'</a></li>';
						$i++;
					}
				}
				
				$data .= '</ul>';
				$data .= '<div id="spc-toggles"><b>Sound</b><input type="checkbox" name="checkbox1" id="checkbox1" class="ios-toggle" checked/>
  							<label for="checkbox1" class="spc-checkbox-label" data-off="off" data-on="on"></label>
						  </div>';
				$data .= '<script type="text/javascript">soundManager.setup({url: "'.$this->plugin_url.'/assets/bgplay/swf/",html5PollingInterval: 50});jQuery("#checkbox1").click(function() {if(jQuery("#checkbox1").is(":checked")){soundManager.resumeAll();}else{soundManager.pauseAll();}}); </script> ';
				
			}
		}
		
		if( $only_state==true){ return false; }
		else{ return $data;}
		
		
	}
	
	/*
	* Admin Header
	*/
	public function getFlakeScript()
	{

		global $wpdb;

		$data_query = "SELECT * FROM {$wpdb->prefix}spc_flakes where flake_show_enable = '1'";
		$rows = $wpdb->get_results( $data_query, OBJECT );    

		//if no flake found return.
		if(count($rows) <= 0 ){ return false; exit; }
		
		//Get current page/post id
		$pid = get_the_ID();
		$is_page = (is_page($pid ));
		$is_single = (is_single($pid));
		
		$script = '';

		foreach($rows as $row)
		{
			
			if( $row->flake_active_page == '0' || ($row->flake_active_page == $pid && ($is_page == true || $is_single==true)) ){
			
				$script .= 'jQuery("'.$row->flake_selector.'").spcGravity({';	
	
				if($row->flake_mode == 'image')
	
				{
	
					$script .= "apples:['".$row->flake_image."'],";	
	
				}else{
	
					$script .= "apples:['".$row->flake_text."'],textMode:true,";	
	
				}
	
				$script .= "totalApples: ".$row->flake_num.",";
	
				if($row->flake_direction == 'dwn')
	
				{
	
					$script .= "wind: false,";
	
				}else{
	
					$script .= "wind: '".$row->flake_direction."',";
	
				}
				
				$script .= "active_area: '".$row->flake_active_area."',";
				$script .= "opacity: ".$row->flake_opacity.",";
	
				if($row->flake_link_enable == '1')
	
				{
	
					$script .= "appleLink: '".$row->flake_link."',";
	
				}
	
				$script .= "g: '".$row->flake_speed."',";
				$script .= "frequency: '".$row->flake_frequency."',";
	
				$script .= "width: '".$row->flake_width."',";
	
				$script .= "height: '".$row->flake_height."',";
	
				$script .= "color: '".$row->flake_color."'});";
			
			}

		}

		$pre_script = '<script type="text/javascript">jQuery(document).ready(function(){';

		$post_script = '});</script>';

		$flake_script = $pre_script. $script . $post_script;	

		return $flake_script;

	}	

}