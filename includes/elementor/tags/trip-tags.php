<?php 

if(!defined('ABSPATH')) exit; // Exit if accessed directly

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;

class Next_Departure_Date extends Tag{
    
    // Define the tag name
    public function get_name(){
        return 'next-departure-date';
    }

    // Define the tag title
    public function get_title(){
        return __('Next Departure Date', 'plugin-name');
    }

    // Set the tag group (custom category under GS Tags)
    public function get_group(){
        return 'gs-tags'; // Custom group "GS Tags"
    }

    public function get_categories(){
        return [Module::TEXT_CATEGORY]; // Allow this tag to be used in dynamic fields
    }

    // Render the tag output (the department title)
    public function render(){
      $trip_id = get_the_ID();
      $dates = get_field('dates', $trip_id);

        if($dates){
            echo $this->get_closest_date($dates);
        }
        else{
            echo 'יפורסם בקרוב';
        }
    }

    private function get_closest_date($dates){
        $closest_date = null;
        $current_time = time();

        foreach ($dates as $date) {
            $departure_date = DateTime::createFromFormat('d-m-Y', $date['departure_date']);
            if ($departure_date && $departure_date->getTimestamp() > $current_time) {
                if ($closest_date === null || $departure_date < $closest_date) {
                    $closest_date = $departure_date;
                }
            }
        }

        return $closest_date ? $closest_date->format('d/m/Y') : 'יפורסם בקרוב';
    }
}