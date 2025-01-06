<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**
 * 
 *  Elementor Journeys Archive Sign Up Form Template
 * 
 * 
 * @var array $settings
 * @var array $journeys_data
 * @var array $journeys_ids
 * @var string $widget_id
 * @var string $form_title
 * @var string $form_description
 */

?>

<div class="sign-up-container">
    <div class="open-popup-button-wrapper" style="background:transparent;">
        <button class="open-popup-button"><?php echo $settings['open_popup_button_text']; ?></button>
    </div>
    <div class="form-wrapper">
        <div class="inner">
            <button type="button" class="close-button"><span>&#215;</span></button>
            <div class="heading">
                <h2 class="form-title"><?php echo $form_title; ?></h2>
            </div>
            <div class="form">
                <form action="post" class="sign-up-form archive">
                    <div class="form-description"><?php echo __($form_description); ?></div>
                    <div class="form-step step-1 active">
                        <div class="input-wrapper type-checkbox">
                            <input type="checkbox" name="acceptance" id="<?php echo $widget_id ?>-acceptance" value="1"
                                required>
                            <label for="<?php echo $widget_id ?>-acceptance">
                                אני מאשר/ת שקראתי והבנתי
                            </label>
                        </div>
                    </div>
                    <div class="form-step step-2">
                        <div class="user-details-wrapper form-section">
                            <div class="input-wrapper type-text">
                                <input type="text" name="full_name" id="<?php echo $widget_id ?>-full-name"
                                    placeholder="שם מלא" required>
                            </div>
                            <div class="input-wrapper type-email">
                                <input type="email" name="email" id="<?php echo $widget_id ?>-email" placeholder="מייל"
                                    required>
                            </div>
                            <div class="input-wrapper type-tel">
                                <input type="tel" name="phone" id="<?php echo $widget_id ?>-phone" placeholder="טלפון"
                                    required style="direction:rtl">
                            </div>
                            <div class="input-wrapper type-date">
                                <input type="text" class="dob" name="dob" id="<?php echo $widget_id ?>-dob"
                                    onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="תאריך לידה"
                                    required max="<?php echo date('Y-m-d', strtotime('-18 years')) ?>">
                            </div>
                            <div class="input-wrapper type-radio">
                                <label>מין</label>
                                <div class="options-wrapper">
                                    <div class="radio-group">
                                        <input type="radio" name="<?php echo $widget_id ?>_gender"
                                            id="<?php echo $widget_id ?>-gender-male" value="זכר" required>
                                        <label for="<?php echo $widget_id ?>-gender-male">זכר</label>
                                    </div>
                                    <div class="radio-group">
                                        <input type="radio" name="<?php echo $widget_id ?>_gender"
                                            id="<?php echo $widget_id ?>-gender-female" value="נקבה" required>
                                        <label for="<?php echo $widget_id ?>-gender-female">נקבה</label>
                                    </div>
                                    <div class="radio-group">
                                        <input type="radio" name="<?php echo $widget_id ?>_gender"
                                            id="<?php echo $widget_id ?>-gender-other" value="אחר" required>
                                        <label for="<?php echo $widget_id ?>-gender-other">אחר</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-step step-3 last">
                        <div class="training-details-wrapper form-section">
                            <div class="input-wrapper condition type-select" data-condition="training-type">
                                <select name="training_type" id="<?php echo "$widget_id$journey_idx" ?>-training-type"
                                    required>
                                    <option value="">סוג הכשרה</option>
                                    <option value="צבאית">צבאית</option>
                                    <option value="אזרחית">אזרחית</option>
                                </select>
                                <div class="custom-select-wrapper" data-prefix="הכשרה">
                                    <label for="<?php echo $widget_id ?>-training-type">סוג הכשרה</label>
                                    <ul class="custom-select-list" for="<?php echo $widget_id ?>-training-type">
                                        <li class="custom-select-item" data-value="צבאית">
                                            <input type="radio" class="list-input"
                                                name="<?php echo $widget_id ?>-training-type-radio"
                                                id="<?php echo $widget_id ?>-training-type-military" value="צבאית">
                                            <label for="<?php echo $widget_id ?>-training-type-military">הכשרה
                                                צבאית</label>
                                        </li>
                                        <li class="custom-select-item" data-value="אזרחית">
                                            <input type="radio" class="list-input"
                                                name="<?php echo $widget_id ?>-training-type-radio"
                                                id="<?php echo $widget_id ?>-training-type-civilian" value="אזרחית">
                                            <label for="<?php echo $widget_id ?>-training-type-civilian">הכשרה
                                                אזרחית</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="input-wrapper condition-res type-number" data-condition="training-type"
                                data-condition-value="צבאית">
                                <input type="text" name="training_number"
                                    id="<?php echo "$widget_id$journey_idx" ?>-training-number" placeholder="מספר קפ״צ">
                            </div>
                            <div class="input-wrapper condition-res type-text" data-condition="training-type"
                                data-condition-value="אזרחית">
                                <input type="text" name="training_institution"
                                    id="<?php echo $widget_id ?>-training-institution" placeholder="סוג קורס">
                            </div>
                            <div class="input-wrapper condition-res type-text" data-condition="training-type"
                                data-condition-value="אזרחית,צבאית">
                                <input type="text" name="unit" id="<?php echo $widget_id ?>-unit"
                                    placeholder="תפקיד בשירות מילואים" required>
                            </div>
                        </div>
                        <div class="journey-details-wrapper form-section">
                            <div class="input-wrapper condition type-select" data-condition="journey-id">
                                <select name="journey_id" id="<?php echo $widget_id ?>-journey-id">
                                    <option value="">בחירת מסע / סדנה</option>
                                    <?php foreach ($journeys_ids as $journey_id): ?>
                                        <option value="<?php echo $journey_id ?>"><?php echo get_the_title($journey_id) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="custom-select-wrapper" data-prefix="">
                                    <label for="<?php echo $widget_id ?>-journey-id">בחירת מסע / סדנה</label>
                                    <ul class="custom-select-list" for="<?php echo $widget_id ?>-journey-id">
                                        <?php foreach ($journeys_ids as $journey_id): ?>
                                            <li class="custom-select-item" data-value="<?php echo $journey_id ?>"
                                                data-label-value="<?php echo get_the_title($journey_id) ?>">
                                                <input type="radio" class="list-input"
                                                    name="<?php echo $widget_id ?>-journey-id-radio"
                                                    id="<?php echo $widget_id ?>-journey-id-<?php echo $journey_id ?>"
                                                    value="<?php echo $journey_id ?>">
                                                <label for="<?php echo $widget_id ?>-journey-id-<?php echo $journey_id ?>">
                                                    <?php echo get_the_title($journey_id) ?></label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php foreach ($journeys_data as $journey_idx => $journey_data):
                                $journey_dates = $journey_data['dates'];
                                $journey_id = $journey_data['id'];
                                if (empty($journey_dates)) { ?>
                                    <div class="input-wrapper condition-res type-message" data-condition="journey-id"
                                        data-condition-value="<?php echo $journey_id ?>">
                                        <p>עדכון לגבי תאריכים עתידיים בקרוב</p>
                                    </div>
                                    <?php continue;
                                }
                                ?>
                                <div class="input-wrapper condition-res type-select" data-condition="journey-id"
                                    data-condition-value="<?php echo $journey_id ?>">
                                    <select name="journey_date" id="<?php echo "{$widget_id}_$journey_idx" ?>-journey-date"
                                        required>
                                        <option value="">תאריך מסע</option>
                                        <?php foreach ($journey_data['dates'] as $date_idx => $date) {
                                            $departure_date = $date['departure_date'] ?? '';
                                            $return_date = $date['return_date'] ?? '';
                                            $is_active_registration = !empty($date['is_active_registration']);
                                            $is_full = !empty($date['is_full']);
                                            if (empty($departure_date) || has_date_passed($departure_date) || !$is_active_registration) {
                                                continue;
                                            }
                                            ?>
                                            <option value="<?php echo $departure_date ?>" <?php echo $is_full ? 'disabled' : '' ?>>
                                                <?php echo $departure_date ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div class="custom-select-wrapper" data-date="true">
                                        <label for="<?php echo $widget_id ?>-journey-date">יש לבחור תאריך מסע</label>
                                        <ul class="custom-select-list" for="<?php echo $widget_id ?>-journey-date">
                                            <?php foreach ($journey_data['dates'] as $date) {
                                                $departure_date = $date['departure_date'] ?? '';
                                                $return_date = $date['return_date'] ?? '';
                                                $is_active_registration = !empty($date['is_active_registration']);
                                                $is_full = !empty($date['is_full']);
                                                if (empty($departure_date) || has_date_passed($departure_date) || !$is_active_registration) {
                                                    continue;
                                                }
                                                ?>
                                                <li class="custom-select-item" data-value="<?php echo $departure_date ?>"
                                                    data-full="<?php echo $is_full ? 'true' : 'false' ?>">
                                                    <input type="radio" class="list-input"
                                                        name="<?php echo $widget_id ?>-journey-date-radio"
                                                        id="<?php echo $widget_id ?>-journey-date-<?php echo $departure_date ?>"
                                                        value="<?php echo $departure_date ?>">
                                                    <label
                                                        for="<?php echo $widget_id ?>-journey-date-<?php echo $departure_date ?>">
                                                        <?php echo format_date_to_hebrew($departure_date) ?>
                                                    </label>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="form-actions-wrapper">
                        <div class="submit-wrapper">
                            <button type="submit" class="submit-button" disabled>שליחה</button>
                        </div>
                        <div class="step-button-wrapper next-step">
                            <button type="button" class="step-button next" disabled>הבא</button>
                        </div>
                        <div class="step-button-wrapper prev-step">
                            <button type="button" class="step-button prev" disabled>הקודם</button>
                        </div>
                    </div>
                    <input type="hidden" name="widget_id" value="<?php echo $widget_id ?>">
                    <input type="hidden" name="is_archive" value="1">
                </form>
            </div>
        </div>
    </div>
</div>