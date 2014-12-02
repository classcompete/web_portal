<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 10/21/13
 * Time: 3:12 PM
 * To change this template use File | Settings | File Templates.
 */
class Image_crop_lib {

    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
    }

    public function process_image($image_name, $values){
        $info       = pathinfo($image_name);
        $file       = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $image_name;
        $temp_file  = X_TEACHER_UPLOAD_PATH . DIRECTORY_SEPARATOR . $info['filename']. '_temp.'.$info['extension'];
        $cropped_file = str_replace("\\","/",X_TEACHER_UPLOAD_PATH) . DIRECTORY_SEPARATOR . $info['filename']. '_cropped.png';
        $new_image = X_TEACHER_UPLOAD_PATH.DIRECTORY_SEPARATOR.$info['filename'].'_current.png';
        $new_image_name = $info['filename'].'_current.png';
        $size       = $this->get_size($file);

        $new_size           = array();
        $new_size['width']  = $size['width'] * ($values['zoom'] / 100);
        $new_size['height'] = $size['height'] * ($values['zoom'] / 100);


        // create base image
        $img = imagecreatetruecolor($values['width'], $values['height']);
        $bg = imagecolorallocate ( $img, $values['red'], $values['green'], $values['blue'] );
        imagefilledrectangle($img,0,0,$values['width'],$values['height'],$bg);
        imagepng($img,$new_image,1);

        // resize image

        $config['source_image']     = $file;
        $config['new_image']        = str_replace("\\","/",X_TEACHER_UPLOAD_PATH) . DIRECTORY_SEPARATOR . $info['filename']. '_resize.'.$info['extension'];
        $config['maintain_ration']  = TRUE;
        $config['width']            = $size['width'] * ($values['zoom']/100);
        $config['height']           = $size['height'] * ($values['zoom']/100);

        $this->ci->load->library('image_lib',$config);

        if(!$this->ci->image_lib->resize()){
            return $this->ci->image_lib->display_errors();
        }

        $resize_image = $config['new_image'];
        $resize_image_size = $this->get_size($resize_image);
        /** check if we need to crop image
         * 1. if x and y are negative
         * 2. if x is positive and y is negative
         * 3. if x and y are positive
         * 4. if x is negative and y is positive
         */
        if($values['x_axis'] <= 0 && $values['y_axis'] <= 0){
            $config['source_image']     = $resize_image;
            $config['new_image']        = $cropped_file;
            $config['maintain_ratio']   = false;
            $config['width']            = $resize_image_size['width'] - ($values['x_axis']*(-1));
            $config['height']           = $resize_image_size['height']- ($values['y_axis']*(-1));

            //check where to start cutting


            $config['x_axis']           = $values['x_axis']*(-1);
            $config['y_axis']           = $values['y_axis']*(-1);

            $this->ci->image_lib->clear();
            $this->ci->image_lib->initialize($config);
            if(!$this->ci->image_lib->crop()){
                return $this->ci->image_lib->display_errors();
            }

            unset($config);
            $config['source_image'] = $new_image;
            $config['wm_type'] = 'overlay';
            $config['wm_overlay_path'] = $cropped_file;
            $config['wm_hor_offset'] = 0;
            $config['wm_vrt_offset'] = 0;
            $config['wm_opacity'] = 100;

            $this->ci->image_lib->clear();
            $this->ci->image_lib->initialize($config);
            if(!$this->ci->image_lib->watermark()){
                return $this->ci->image_lib->display_errors();
            }

            return $new_image_name;

        }
        else if($values['x_axis'] >= 0 && $values['y_axis'] < 0){
            $config['source_image']     = $resize_image;
            $config['new_image']        = $cropped_file;
            $config['maintain_ratio']   = false;
            $config['width']            = $resize_image_size['width'];
            $config['height']           = $resize_image_size['height'] - ($values['y_axis']*(-1));

            //check where to start cutting

            $config['x_axis']           = 0;
            $config['y_axis']           = $values['y_axis']*(-1);
            $this->ci->image_lib->clear();
            $this->ci->image_lib->initialize($config);
            if(!$this->ci->image_lib->crop()){
                return $this->ci->image_lib->display_errors();
            }

            unset($config);
            $config['source_image'] = $new_image;
            $config['wm_type'] = 'overlay';
            $config['wm_overlay_path'] = $cropped_file;
            $config['wm_hor_offset'] = $values['x_axis'];
            $config['wm_vrt_offset'] = 0;
            $config['wm_opacity'] = 100;

            $this->ci->image_lib->clear();
            $this->ci->image_lib->initialize($config);
            if(!$this->ci->image_lib->watermark()){
                return $this->ci->image_lib->display_errors();
            }

            return $new_image_name;
        }
        else if($values['x_axis'] >= 0 && $values['y_axis'] >= 0){
            $config['source_image']     = $resize_image;
            $config['new_image']        = $cropped_file;
            $config['maintain_ratio']   = false;
            $config['width']            = (($values['width'] - $values['x_axis']) > $resize_image_size['width'] ) ? $resize_image_size['width'] : ($values['width'] - $values['x_axis']);
            $config['height']           = (($values['height'] - $values['y_axis']) > $resize_image_size['height'] ) ? $resize_image_size['height'] : ($values['height'] - $values['y_axis']);

            //check where to start cutting

            $config['x_axis']           = 0;
            $config['y_axis']           = 0;
            $this->ci->image_lib->clear();
            $this->ci->image_lib->initialize($config);
            if(!$this->ci->image_lib->crop()){
                return $this->ci->image_lib->display_errors();
            }

            unset($config);
            $config['source_image'] = $new_image;
            $config['wm_type'] = 'overlay';
            $config['wm_overlay_path'] = $cropped_file;
            $config['wm_hor_offset'] = $values['x_axis'];
            $config['wm_vrt_offset'] = $values['y_axis'];
            $config['wm_opacity'] = 100;

            $this->ci->image_lib->clear();
            $this->ci->image_lib->initialize($config);
            if(!$this->ci->image_lib->watermark()){
                return $this->ci->image_lib->display_errors();
            }

            return $new_image_name;
        }
        else if($values['x_axis'] < 0 && $values['y_axis'] >= 0){
            $config['source_image']     = $resize_image;
            $config['new_image']        = $cropped_file;
            $config['maintain_ratio']   = false;
            $config['width']            = $resize_image_size['width'] - $values['x_axis']*(-1);
            $config['height']           = (($values['height'] - $values['y_axis']) > $resize_image_size['height'] ) ? $resize_image_size['height'] : ($values['height'] - $values['y_axis']);

            //check where to start cutting

            $config['x_axis']           = $values['x_axis'] * (-1);
            $config['y_axis']           = 0;
            $this->ci->image_lib->clear();
            $this->ci->image_lib->initialize($config);
            if(!$this->ci->image_lib->crop()){
                return $this->ci->image_lib->display_errors();
            }
            unset($config);
            $config['source_image'] = $new_image;
            $config['wm_type'] = 'overlay';
            $config['wm_overlay_path'] = $cropped_file;
            $config['wm_hor_offset'] = 0;
            $config['wm_vrt_offset'] = $values['y_axis'];
            $config['wm_opacity'] = 100;

            $this->ci->image_lib->clear();
            $this->ci->image_lib->initialize($config);
            if(!$this->ci->image_lib->watermark()){
                return $this->ci->image_lib->display_errors();
            }

            return $new_image_name;
        }

    }
    private function get_size($image){
        $img = getimagesize($image);

        return Array('width'=>$img['0'], 'height'=>$img['1']);
    }
}