<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 
 * Journey Management Template
 * 
 * @var string $journey_id
 * @var array $journey_dates
 * @var array $journey_statuses
 * @var array  $journey_contacts
 */
?>

<div id="journey-management">
    <div id="journey-dates">
        <ul class="dates-list">
            <li class="dates-heading">
                <div class="departure-date"><label for="">תאריך התחלה</label></div>
                <div class="sign-up"><label for="">הרשמה</label></div>
                <div class="participants"></div>
            </li>
            <?php foreach ($journey_dates as $date) {
                $departure_date = $date['departure_date'];
                $max_participants = $date['number_of_participants'];
                $participants = !empty($date['participants']) && $date['participants'] !== 'null' ? json_decode($date['participants']) : [];
                $participants_count = count($participants);
                $participants_list_template_path = CHILD_THEME_DIR . '/includes/admin/templates/participants-list.php';
                ?>
                <li class="date-item">
                    <div class="details">
                        <div class="departe-date">
                            <p><?php echo str_replace('-', '/', $departure_date) ?></p>
                        </div>
                        <div class="sign-up">
                            <span><?php echo $participants_count ?></span><span>/</span><span><?php echo $max_participants ?></span>
                        </div>
                        <div class="participants">
                            <button type="button" class="participants-list-button">רשימת משתתפים</button>
                        </div>
                    </div>
                    <?php
                    get_template_part('includes/admin/templates/participants', 'list', [
                        'participants' => $participants,
                        'journey_statuses' => $journey_statuses,
                        'journey_contacts' => $journey_contacts,
                        'departure_date' => $departure_date
                    ]);
                    ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>