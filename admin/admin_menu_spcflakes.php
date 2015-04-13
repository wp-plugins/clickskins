<?php

/*
* Function for settings menu
*/

function spcFlakes(){
    
    $datalist_obj = new SpcSampleData();
    
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style( 'wp-color-picker' );
}

function spcFlakesSettings()
{
    $ccl_obj = new SpcSampleData('settings');
    
}

/*
* Class for sample data
*/

class SpcSampleData extends SnapycodeFlake
{
    
    public function __construct($fn='')
    {
        
        if($fn=='settings')
        {
            if(isset($_POST['flake_settings_record']))
            {
                update_option( 'ghostskin_flake_music', sanitize_text_field($_POST['flake_music']) );
            }
            
            $this->settings();
            
        }
        else{
                
            // save and update sample data
            if( isset($_POST['flake_record']) )
            {
                $this->flakeRecord();
                //update_option('enable_music',$_POST['flake_music_enable']);
            }
            
            //call list view or single view 
            if( isset($_GET['addnew']) || ( isset($_GET['action']) && $_GET['action']=='edit' ) )
            {
                $this->flake();
            }
            else{
                $this->flakes();
            }
        }
    }
    
    /*
    * Function for settings data
    */
    public function settings()
    {
        ?>
        <div class="wrap snapycode_flake_admin_wrap"> 
            <?php $this->admin_head(); ?>
            
            <div id="icon-spc-admin-settings" class="admin-page-icon"><br></div>
            <h2>Click Skins Audio Settings</h2>
            <br class="clear">
            
            <div class="spc-flake-wrap" id="poststuff">
                
                <div class="postbox">
                    <h3><span>Click Skins</span></h3>
                    
                    <form name="flake_form" id="flake_form" method="post" action="" enctype="multipart/form-data">
                                    
                        <div class="inside">
                                                    
                            <div class="spc-width60 spc-float-left" style="padding-bottom:20px;"><!-- Form Elements -->
                                                                                       
                                <div class="postarea">                  
                                    <label for="flake_music"  class="spc_label spc-width50">BG MP3 List<br/><small>mp3 url list seperated by comma</small> </label>
                                    <textarea id="" name="flake_music" class="spc-width70 medium-text" rows="" cols="" ><?php 
                                     echo get_option( 'ghostskin_flake_music', '' );
                                    ?></textarea>    
                                    
                                </div>          
                                
                            </div><!-- Form Elements End-->
                            
                            <div class="spc-infos spc-float-right"><!-- Information Element -->
                            
                                <div class="postbox client_wrap" >
                                    <h3><span>Guide </span></h3>
                                    
                                    <div class="inside">
                                        <div class="postarea">                  
                                           <p class="stat">
                                             <span class="spc_info_value">BG MP3 List: </span>
                                             <span class="spc_info"> &nbsp;&nbsp;<code>This list will play as background music. <br/>Ex- http://freshly-ground.com/data/audio/mpc/20060812%20-%20Groove.mp3</code></span>
                                             </p>
                                          
                                         </div>
                                       </div>
                                        
                                    </div>
                                    
                                </div>
                                                            
                            </div><!-- Information Element End -->
                            
                            <div class="spc-width60 spc-float-left" style="padding-bottom:20px; text-align:center;">
                                
                             <input type="submit" accesskey="p" value="Save Settings" 
                                    class="button button-primary button-large" id="publish" name="flake_settings_record">
                            </div>        
                         
                        </div>
                        
                    </form>
                    
                </div>

            </div>
         </div> 
         <?php
    }
    
    /*
    * Function for show data list
    */
    private function flakes()
    {
        ?>
        <div class="wrap snapycode_flake_admin_wrap">
            <?php $this->admin_head(); ?>
            
            <div id="icon-spc-admin-flake" class="admin-page-icon"><br></div>
            <h2>Click Skins List <a class="add-new-h2" href="admin.php?page=<?php echo $_REQUEST['page']; ?>&amp;addnew">Add New ClickSkin</a></h2>
            <br class="clear">
            
            <div class="spc-flake-wrap" id="poststuff">
            <?php
                 $flakeListTable = new Sample_Data_List();
                 $flakeListTable->prepare_items();
            ?>
            <form method="post">
                <input type="hidden" name="page" value="flake_list_table">
                <?php
                $flakeListTable->search_box( 'search', 'search_id' );
                
                $flakeListTable->display(); 
              ?>
            </form>  
            </div>
         </div>     
        <?php
    }
    
    /*
    * Function for add and update sample data.
    */
    private function flake()
    {
        global $wpdb;
        
        if( isset($_GET['flake']) && ($flake_id = (int)sanitize_text_field($_GET['flake'])) != 0 ){ 
            
            $query = "SELECT * FROM {$wpdb->prefix}spc_flakes WHERE `id`='{$flake_id}' LIMIT 0,1";
            $row = $wpdb->get_row( $query );  
            //print_r($row);
        } 
        
        ?>
        <div class="wrap snapycode_flake_admin_wrap"> 
            
            
            <div id="icon-spc-admin-flake" class="admin-page-icon"><br></div>
            <h2><?php if( isset($flake_id) ){ echo 'Edit'; }else{ echo 'New'; } ?> Click Skin 
                <a class="add-new-h2" href="admin.php?page=<?php echo $_REQUEST['page']; ?>">All Click Skin</a>
            </h2>
            <br class="clear">
            <?php $this->admin_head(); ?>
            <div class="spc-flake-wrap" id="poststuff">
                
                <div class="postbox">
                    <h3><span><?php if( isset($flake_id) ){ echo 'Edit'; }else{ echo 'New'; } ?> Click Skin</span></h3>
                    
                    <form name="flake_form" id="flake_form" method="post" action="" enctype="multipart/form-data">
                    
                        <div class="inside">
                                                    
                            <div class="spc-width60 spc-float-left" style="padding-bottom:20px;"><!-- Form Elements -->
                                                         
                                <div class="postarea">                  
                                    <label for="flake_text"  class="spc_label"> Text</label>
                                    <input type="text" id="flake_text" class="spc-width50 medium-text" name="flake_text" 
                                    value="<?php if( isset($row->flake_text) ){ echo $row->flake_text; }?>" tabindex="1" >
                                    
                                </div>
                                
                                <div class="postarea spc_image_upload">  
                                    <label for="flake_image" class="spc_label">Image</label>
                                    <input type="text" class="spc_image_url spc-width50 medium-text" name="flake_image" 
                                    value="<?php if(isset($row->flake_image)){echo $row->flake_image; }?>" />
                                    
                                    <div class="spc-width50" style="text-align:center;">
                                        <div class="spc_image_wrap">
                                            <?php if(isset($row->flake_image) && ('' != trim($row->flake_image)) ){
                                                echo '<img src="'.$row->flake_image.'" width="100" height="100" />'; 
                                                }
                                            ?> 
                                        </div>
                                        <input type="button" class="button" value="Choose File" onclick="spc_upload_image(this)" />
                                        <input class="button" type="button" value="Remove" onclick="spc_remove_image(this)" /> 
                                    </div>
                                </div>
                               <div class="postarea">                   
                                    <label for="flake_selector"  class="spc_label"> Live Link </label>
                                    <a href="#">Buy Pro Version</a>
                                </div>
                               <div class="postarea">                   
                                    <label for="flake_selector"  class="spc_label"> Selector </label>
                                    <input type="text" id="flake_selector" class="spc-width50 medium-text" name="flake_selector" 
                                    value="<?php if( isset($row->flake_selector) ){ echo $row->flake_selector; }else{ echo 'body';}?>" tabindex="2" >
                                    
                                </div>
                                                               
                                <div class="postarea">                  
                                    <label for="flake_active_area"  class="spc_label"> Active Area </label>
                                    
                                    <select name="flake_active_area" id="flake_active_area" tabindex="5">
                                        <option <?php if( isset($row->flake_active_area) && ($row->flake_active_area=='Complete Page') ) echo 'selected="selected"'; ?> 
                                                value="Complete Page">Complete Page</option>
                                        <option <?php if( isset($row->flake_active_area) && ($row->flake_active_area=='Narrow Left') ) echo 'selected="selected"'; ?> 
                                                value="Narrow Left">Narrow Left</option>
                                        <option <?php if( isset($row->flake_active_area) && ($row->flake_active_area=='Narrow Right') ) echo 'selected="selected"'; ?> 
                                                value="Narrow Right">Narrow Right</option>                
                                    </select>
                                    
                                </div>
                                
                                <div class="postarea">                  
                                    <label for="flake_active_page"  class="spc_label"> Active Page/Post </label>
                                    <select name="flake_active_page" id="flake_active_page" tabindex="6">
                                    <option value="0">All Pages</option>
                                    <?php
                                    $pages = get_pages(); 
									  foreach ( $pages as $page ) {
										$option = '<option ';
										if( isset($row->flake_active_page) && ($row->flake_active_page==$page->ID) ){
											$option .= 'selected="selected"';
										}
										$option .= ' value="' .  $page->ID  . '">';
										$option .= $page->post_title;
										$option .= '</option>';
										echo $option;
									  } 
									  
									 global $post;
									 $args = array( 'numberposts' => -1);
									 $posts = get_posts($args);
									 foreach( $posts as $post ) : setup_postdata($post); ?>
										<option <?php if( isset($row->flake_active_page) && ($row->flake_active_page==$post->ID) ) echo 'selected="selected"'; ?> 
                                        value="<?php echo $post->ID; ?>"><?php the_title(); ?></option>
									 <?php endforeach; ?>  
									
                                    </select>
                                </div>
                                
                            </div><!-- Form Elements End-->
                            
                            <div class="spc-infos spc-float-right"><!-- Information Element -->
                            
                                <div class="postbox client_wrap" >
                                    <h3><span>Settings </span></h3>
                                    
                                    <div class="inside">
                                        <div class="postarea">                  
                                            <label for="flake_mode"  class="spc_label_2 "> Mode</label>
                                            <div class="option_group">
    
                                            <input type="radio" value="text" name="flake_mode" 
                                            <?php if( $row->flake_mode=='text') echo 'checked="checked"'; ?> >Text
                                            
                                            <input type="radio" value="image" name="flake_mode" 
                                            <?php if( !isset($row->flake_mode) || $row->flake_mode !='text' ) echo 'checked="checked"'; ?> >Image
                                          
                                            </div>
                                       </div>
                                       
                                       
                                       <div class="postarea">                   
                                            <label for="flake_music_enable"  class="spc_label_2"> Enable Music </label>
                                            
                                            <input type="hidden" value="0" name="flake_music_enable"><!-- needed for radios -->
                                            <input type="checkbox" value="1" name="flake_music_enable" 
                                           <?php if( isset($row->flake_music_enable) && ($row->flake_music_enable=='1') ) echo 'checked="checked"'; ?> >
                                       </div>
                                       
                                       <div class="postarea">                   
                                            <label for="flake_hide_front"  class="spc_label_2"> Hide Front end </label>
                                            
                                            <input type="hidden" value="1" name="flake_show_enable"><!-- needed for radios -->
                                            <input type="checkbox" value="0" name="flake_show_enable" 
                                           <?php if( isset($row->flake_show_enable) && ($row->flake_show_enable=='0') ) echo 'checked="checked"'; ?> >
                                       </div>
                                       <div class="postarea">                   
                                            <label for="flake_direction"  class="spc_label_2"> Direction</label>
                                            <select name="flake_direction" id="flake_direction" tabindex="3">
                                                <option <?php if( !isset($row->flake_direction) ||  ($row->flake_direction=='dwn') ) 
                                                echo 'selected="selected"'; ?> value="dwn">Downward</option>
                                                <option <?php if( isset($row->flake_direction) && ($row->flake_direction=='left') ) echo 'selected="selected"'; ?> 
                                                value="left">Downward Left</option>
                                                <option <?php if( isset($row->flake_direction) && ($row->flake_direction=='right') ) echo 'selected="selected"'; ?> 
                                                value="right">Downward Right</option>
                                                <option <?php if( isset($row->flake_direction) && ($row->flake_direction=='reverse') ) echo 'selected="selected"'; ?> 
                                                value="reverse">Upward</option>
                                                <option <?php if( isset($row->flake_direction) && ($row->flake_direction=='rleft') ) echo 'selected="selected"'; ?> 
                                                value="rleft">Upward Left</option>
                                                <option <?php if( isset($row->flake_direction) && ($row->flake_direction=='rright') ) echo 'selected="selected"'; ?> 
                                                value="rright">Upward Right</option>
                                            </select>
                                            
                                        </div>
                                        
                                        <div class="postarea">                  
                                            <label for="flake_num"  class="spc_label_2"> Number of Skin</label>
                                            <input type="text" id="flake_num" class="spc-width50 medium-text" name="flake_num" 
                                            value="<?php if( isset($row->flake_num) ){ echo $row->flake_num; }?>" tabindex="1" >
                                            
                                        </div>
                                            
                                        <div class="postarea">                  
                                            <label for="flake_speed"  class="spc_label_2"> Slowness<br/><small>Ex - 20 </small></label>
                                            <input type="text" id="flake_speed" class="spc-width50 medium-text" name="flake_speed" 
                                            value="<?php if( isset($row->flake_speed) ){ echo $row->flake_speed; }?>" tabindex="1" >
                                            
                                        </div>
                                        
                                        <div class="postarea">                  
                                            <label for="flake_frequency"  class="spc_label_2"> Frequency<br/><small>Ex - 1 </small></label>
                                            <input type="text" id="flake_frequency" class="spc-width50 medium-text" name="flake_frequency" 
                                            value="<?php if( isset($row->flake_frequency) ){ echo $row->flake_frequency; }?>" tabindex="1" >
                                            
                                        </div>
                                        
                                       <div class="postarea">                   
                                            <label for="flake_opacity"  class="spc_label_2"> Opacity <br/><small>0.1 to 1 </small></label>
                                            <input type="text" id="flake_opacity" class="spc-width50 medium-text" name="flake_opacity" 
                                            value="<?php if( isset($row->flake_opacity) ){ echo $row->flake_opacity; }?>" tabindex="1" >
                                            
                                       </div>
                                       
                                       <div class="postarea">                   
                                            <label for="flake_width"  class="spc_label_2"> Width <br/><small>Ex - 200 (px)</small></label>
                                            <input type="text" id="flake_width" class="spc-width50 medium-text" name="flake_width" 
                                            value="<?php if( isset($row->flake_width) ){ echo $row->flake_width; }?>" tabindex="1" >
                                            
                                       </div>
                                       
                                       <div class="postarea">                   
                                            <label for="flake_height"  class="spc_label_2"> Height <br/><small>Ex - 200 (px) / auto</small></label>
                                            <input type="text" id="flake_height" class="spc-width50 medium-text" name="flake_height" 
                                            value="<?php if( isset($row->flake_height) ){ echo $row->flake_height; }?>" tabindex="1" >
                                            
                                       </div>
                                       
                                       <div class="postarea">                   
                                            <label for="flake_color"  class="spc_label_2"> Text Color</label>
                                            <input type="text" id="flake_color" class="spc-width50 medium-text" name="flake_color" 
                                            value="<?php if( isset($row->flake_color) ){ echo $row->flake_color; }?>" data-default-color="#000" tabindex="1" >
                                            
                                       </div>
                                       
                                    </div>
                                    
                                </div>
                                                            
                            </div><!-- Information Element End -->
                            
                            <div class="spc-width60 spc-float-left" style="padding-bottom:20px;">
                                
                             <input type="hidden" name="flake_id" value="<?php if( isset($flake_id) ){ echo $flake_id; } ?>" />
                             <input type="submit" accesskey="p" value="Save Skin" 
                                    class="button button-primary button-large" id="publish" name="flake_record">
                            </div>        
                         
                        </div>
                        
                    </form>
                    
                </div>

            </div>
         </div>
         
        <?php
    }
    
    /*
    * Function to record Data
    */
    private function flakeRecord()
    {
        global $wpdb;
        //var_dump($_POST); exit;
        extract($_POST);
                
        if( '' == trim($flake_text) && '' == trim($flake_image) ){ $this->set_message( 'You must put Text or an Image.', $type='error'); return false; }
        if( '' == trim($flake_selector) ){ $flake_selector = 'body';}
        if( '' == trim($flake_active_area) ){ $flake_active_area = 'Complete Page';}        
        if( '' == trim($flake_mode) ){ $flake_mode = 'image';}
        if( '' == trim($flake_link_enable) ){ $flake_link_enable = 0;}
        if( '' == trim($flake_music_enable) ){ $flake_music_enable = 0;}        
        if( '' == trim($flake_direction) ){ $flake_direction = 'dwn';}
        if( '' == trim($flake_num) ){ $flake_num = 1;}
        if( '' == trim($flake_mode) ){ $flake_mode = 'image';}
        if( '' == trim($flake_opacity) ){ $flake_opacity = 1;}
        if( '' == trim($flake_color) ){ $flake_color = '#000';}
        if( '' == trim($flake_width) ){ $flake_width = '100';}
        if( '' == trim($flake_height) ){ $flake_height = 'auto';}
        if( '0' == (int)($flake_speed) ){ $flake_speed = 20;}
        if( '0' == (int)($flake_frequency) ){ $flake_frequency = 1;}
        
		$flake_active_page = (int)$flake_active_page;
		
		//make width integer
		$flake_width = intval($flake_width);
		       
        $flake_table = $wpdb->prefix.'spc_flakes';
        $data = array( 
                        'flake_text'=>esc_sql( sanitize_text_field($flake_text)), 
                        'flake_image'=> esc_sql( sanitize_text_field($flake_image) ), 
                        'flake_link'=> '', 
                        'flake_show_enable'=> esc_sql( sanitize_text_field($flake_show_enable) ), 
                        'flake_selector'=> esc_sql( sanitize_text_field($flake_selector) ),
                        'flake_active_area'=> esc_sql( sanitize_text_field($flake_active_area) ),
						'flake_active_page'=> esc_sql( sanitize_text_field($flake_active_page) ),
                        'flake_mode'=> esc_sql( sanitize_text_field($flake_mode) ),
                        'flake_link_enable'=> esc_sql( sanitize_text_field($flake_link_enable) ),
                        'flake_music_enable'=> esc_sql( sanitize_text_field($flake_music_enable) ),
                        'flake_direction'=> esc_sql( sanitize_text_field($flake_direction) ),
                        'flake_num'=> esc_sql( sanitize_text_field($flake_num) ),
                        'flake_speed'=> esc_sql( sanitize_text_field($flake_speed)), 
                        'flake_frequency'=> esc_sql( sanitize_text_field($flake_frequency)), 
                        'flake_opacity'=> esc_sql( sanitize_text_field($flake_opacity)), 
                        'flake_width'=> esc_sql( sanitize_text_field($flake_width)), 
                        'flake_height'=> esc_sql( sanitize_text_field($flake_height)), 
                        'flake_color'=> esc_sql( sanitize_text_field($flake_color)) 
                    );
        $format = array( '%s','%s','%s','%s', '%s','%s','%s', '%s','%s','%s', '%s','%s','%s', '%s', '%s', '%s', '%s', '%s' );
        
        //var_dump($data); exit;
        
        if( isset($flake_id) && !empty($flake_id) )
        {
            $wpdb->update( 
                $flake_table, 
                $data,
                array( 'id' => $flake_id ), 
                $format, 
                array( '%d' ) 
            );
            
            $this->set_message(  'ClickSkin updated successfully.', $type='success'); return true;
            
        }else{
            
            $wpdb->insert( 
                $flake_table, 
                $data, 
                $format
            );
            
           $this->set_message(  'ClickSkin saved successfully.', $type='success'); return true;
        }
        
    }

}

class Sample_Data_List extends WP_List_Table {
    
    var $list_data = array();

    function __construct(){
        
        global $status, $page, $wpdb, $snapycode_flake;
                
        $this->list_data = $this->getData();
        
        parent::__construct( array(
            'singular'  => 'flake',     //singular name of the listed records
            'plural'    => 'flakes',    //plural name of the listed records
            'ajax'      => false            //does this table support ajax?
        ) );
    }
    
    public function getData()
    {
        global $wpdb, $snapycode_flake;
        
        if( isset($_POST['s']) && !empty($_POST['s']) ){ $find=sanitize_text_field( $_POST['s'] ); $where = " WHERE `flake_text` LIKE %{$find}%";}
        $data_query = "SELECT * FROM {$wpdb->prefix}spc_flakes ".' '.$where;
        $rows = $wpdb->get_results( $data_query, OBJECT );    
        
        $dataPoints = array();
        
        foreach($rows as $row)
        {   
            if( isset($row->flake_image) && '' != trim($row->flake_image) )
            {
                $image  = '<img src="'.$row->flake_image.'" width="50" height="50" />';
            }else{
                $image = '';    
            }
        
            $dataPoints[] = array('ID'=>$row->id, 'flake_text'=>$row->flake_text, 'flake_image'=> $image, 'flake_selector'=> $row->flake_selector, 
                                  'flake_mode'=>$row->flake_mode);
        }
        
        return $dataPoints;
    }
    
   function column_default($item, $column_name){
        switch($column_name){
            case 'flake_selector':
                return $item[$column_name];
            case 'flake_text':
                return $item[$column_name];
            case 'flake_image':
                return $item[$column_name];
            case 'flake_mode':
                return $item[$column_name]; 
            default:

                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }
    
    function column_flake_selector($item){ ### function name will be the column_field under which edit and delete option will show.
        
        //Build row actions
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&flake=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&flake=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID']),
        );
        
        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
            /*$1%s*/ $item['flake_selector'],
            /*$2%s*/ $item['ID'],
            /*$3%s*/ $this->row_actions($actions)
        );
    }
    
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("video")
            /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
        );
    }
    
    function get_columns(){
        $columns = array(
            'cb'                => '<input type="checkbox" />', //Render a checkbox instead of text
            'flake_selector'    => 'Selector',
            'flake_text'        => 'Text',
            'flake_image'      => 'Image',
            'flake_mode'        => 'Mode'
        );
        return $columns;
    }
    
    function get_sortable_columns() {
        $sortable_columns = array(
            'flake_selector'     => array('flake_selector',true),    //true means its already sorted
            'flake_mode'         => array('flake_mode',false)
           
        );
        return $sortable_columns;
    }
    
    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }
    
    function process_bulk_action() {
        global $wpdb;
        $table = "{$wpdb->prefix}spc_flakes";
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            $flakes = $_REQUEST['flake'];
            //print_r($_REQUEST); exit;
            if(is_array($flakes))
            {
                foreach($flakes as $flake)
                {
                    $query = "DELETE FROM $table WHERE `id`=$flake";
                    $wpdb->query($query);
                                        
                }
            }
            else
            {               
                $query = "DELETE FROM $table WHERE `id`=$flakes";
                $wpdb->query($query);
                echo '<div class="update"><p>'. $ack[1] .'</p></div>';
    
            }
            
            wp_redirect( get_bloginfo('wpurl').'/wp-admin/admin.php?page=clickskins/admin/admin_init.php', 301 ); exit;
        }        
               
    }
    
    function prepare_items() {
        
        /*
         * First, lets decide how many records per page to show
         */
        $per_page = 5;
        
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columns, $hidden, $sortable);
        
        $this->process_bulk_action();
        
        $data = $this->list_data;
                
        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? sanitize_text_field($_REQUEST['orderby']) : 'ID'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? sanitize_text_field($_REQUEST['order']) : 'asc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }

        usort($data, 'usort_reorder');
        
        $current_page = $this->get_pagenum();
        
        $total_items = count($data);
        
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        
        $this->items = $data;
        
        /*
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}
?>
