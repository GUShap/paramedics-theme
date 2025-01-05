<?php

if (!defined('ABSPATH')) {
    exit;
}
/**
 * 
 * Participants List Template
 * 
 */
$participants = $args['participants'];
$journey_statuses = $args['journey_statuses'];
$journey_contacts = $args['journey_contacts'];
$departure_date = $args['departure_date'];
?>

<div class="participants-list-wrapper">
    <ul class="participants-list">
        <li class="participant-heading">
            <div class="index"></div>
            <div class="participant-name">פרטים</div>
            <div class="participant-age">גיל</div>
            <div class="participant-gender">מין</div>
            <div class="participant-training">מספר קפ״צ / הכשרה</div>
            <div class="participant-flexability">גמישות בתאריך</div>
            <div class="participant-status">סטטוס</div>
            <div class="participant-contact">איש קשר</div>
            <div class="participant-actions">פעולות</div>
        </li>
        <?php foreach ($participants as $idx => $participant) { ?>
            <li class="participant">
                <span class="index"><?php echo $idx + 1 ?></span>
                <div class="details">
                    <p class="details-item participant-name"><?php echo $participant->name; ?></p>
                    <p class="details-item participant-email"><?php echo $participant->email; ?></p>
                    <p class="details-item participant-phone"><?php echo $participant->phone; ?></p>
                </div>
                <div class="participant-age">
                    <?php
                    $dob = DateTime::createFromFormat('d/m/Y', $participant->dob);
                    $today = new DateTime();
                    $age = $today->diff($dob)->y;
                    ?>
                    <p><?php echo $age; ?></p>
                </div>
                <div class="participant-gender"><?php echo $participant->gender; ?></div>
                <div class="participant-training">
                    <?php
                    $training_text = $participant->training_type == 'צבאית' ? $participant->training_number : $participant->training_institution;
                    ?>
                    <p><?php echo $training_text; ?></p>
                </div>
                <div class="participant-flexability"><input type="checkbox" name="is_flexible[<?php echo $departure_date ?>][<?php echo $idx ?>]" <?php echo !empty($participant->is_flexible) ? 'checked' : '' ?> value="1" /></div>
                <div class="participant-status">
                    <?php $participant_status = $participant->status; ?>
                    <select class="participant-status-select" name="participant_status[<?php echo $departure_date ?>][<?php echo $idx ?>]">
                        <?php foreach ($journey_statuses as $status) {
                            $status_name = $status['status'];
                            $status_color = $status['status_color'];
                            $is_default_status = !empty($status['default']);
                            $is_current_selected = $participant_status == $status_name;
                            if (empty($participant_status) && $is_default_status) {
                                $is_current_selected = true;
                            }
                            ?>
                            <option value="<?php echo $status_name; ?>" <?php echo $is_current_selected ? 'selected' : ''; ?>
                                data-color="<?php echo $status_color ?>"><?php echo $status_name; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="participant-contact">
                    <?php $participant_contact = $participant->contact ?? '';?>
                    <select class="participant-contact-select" name="participant_contact[<?php echo $departure_date ?>][<?php echo $idx ?>]">
                        <option value="" disabled selected>לא משוייך</option>
                        <?php foreach ($journey_contacts as $contact) {
                            $contact_name = $contact['contact_name'];
                            $is_current_selected = $participant_contact == $contact_name;
                            ?>
                            <option value="<?php echo $contact_name; ?>" <?php echo $is_current_selected ? 'selected' : ''; ?>>
                                <?php echo $contact_name; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="participant-actions">
                    <button type="button" class="participant-action" data-action="remove">מחיקה</button>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>