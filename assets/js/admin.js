if (typeof $ == 'undefined') {
    var $ = jQuery;
}

$(document).ready(function () {
    setJourneyAdminArea();
});

function setJourneyAdminArea() {
    const $journeyManagement = $('#journey-management');
    setParticipantsList($journeyManagement);
    setParticipantsStatusSelect($journeyManagement)
}

function setParticipantsStatusSelect($journeyManagement) {
    const $participantsList = $journeyManagement.find('ul.participants-list');
    const $participantsStatusSelect = $participantsList.find('.participant-status-select');

    $participantsStatusSelect.on('change', function () {
        const $statusSelect = $(this);
        const selectedStatus = $statusSelect.val();
        const selectedColor = $statusSelect.find(`option[value="${selectedStatus}"]`).data('color');
        $statusSelect.css('background-color', selectedColor);
    });

    $participantsStatusSelect.trigger('change');
}

function setParticipantsList($journeyManagement) {
    const $datesList = $journeyManagement.find('.dates-list');
    const $dateItems = $datesList.find('.date-item');
    const $participantsListButton = $dateItems.find('.participants-list-button');

    $participantsListButton.on('click', function (e) {
        const $dateItem = $(this).closest('.date-item');
        const $participantsListWrapper = $dateItem.find('.participants-list-wrapper');

        $participantsListWrapper.toggleClass('active');
    });
}
// function setSingleDate($dateRow) {
//     const $participantsListButton = $dateRow.find('.participants-list-button');
//     const $participantsList = $dateRow.find('td[data-name="participants"] input');
//     const departureDate = $dateRow.find('td[data-name="departure_date"] input[type="text"]').val();
//     const journeyTitle = $('#title').val();
//     const postID = $('#post_ID').val();

//     $participantsListButton.on('click', function (e) {
//         e.preventDefault();
//         const $container = $(this).closest('.postbox-container');
//         const $popupHTML = setParticipantsPopup($participantsList, journeyTitle, departureDate, postID);
//         $container.append($popupHTML);
//     });
// }

// function setParticipantsPopup($participantsList, journeyTitle, departureDate, postID) {
//     const participants = $participantsList.val();
//     const participantsArray = JSON.parse(participants);

//     const $popup = $(`<div class="participants-list-popup" data-departure="${departureDate}"><div class="popup-content"></div></div>`);
//     const $popupContent = $popup.find('.popup-content');
//     const $popupHeading = $(`<div class="participants-list-heading"><h3>משתתפי מסע/סדנה ${journeyTitle} בתאריך ${departureDate}</h3></div>`);
//     const $popupParticipantsList = $(`<ul class="participants-list">${getParticipntsHeading()}</ul>`);

//     participantsArray.forEach(function (participant, index) {
//         $popupParticipantsList.append(getSingleParticipantEl(participant, index, postID, departureDate));
//     });
//     $popupContent.append($popupHeading, $popupParticipantsList);

//     return $popup;
// }

// function getParticipntsHeading() {
//     return `
//         <li class="participant-heading">
//             <div class="index"></div>
//             <div class="participant-name">פרטים</div>
//             <div class="participant-age">גיל</div>
//             <div class="participant-gender">מין</div>
//             <div class="participant-training">מספר קפ״צ / הכשרה</div>
//             <div class="participant-flexability">גמישות בתאריך</div>
//             <div class="participant-status">סטטוס</div>
//             <div class="participant-contact">איש קשר</div>
//             <div class="participant-actions">פעולות</div>
//         </li>
//     `;
// }

// function getSingleParticipantEl(participant, index, postID, departureDate) {
//     const $listItem = $(`<li class="participant"><span class="index">${index + 1}</span></li>`);

//     const participantDetails = () => {
//         const name = participant.name;
//         const email = participant.email;
//         const phone = participant.phone;
//         const $details = $(`
//             <div class="details">
//                 <p class="details-item participant-name">${name}</p>
//                 <p class="details-item participant-email">${email}</p>
//                 <p class="details-item participant-phone">${phone}</p>
//             </div>`);
//         $details.find('.details-item').on('click', function () {
//             navigator.clipboard.writeText($(this).text());
//         });
//         return $details;
//     }

//     const participantAge = () => {
//         const [day, month, year] = participant.dob.split('/').map(Number);
//         const dob = new Date(year, month - 1, day);
//         const ageDifMs = Date.now() - dob.getTime();
//         const ageDate = new Date(ageDifMs);
//         const age = Math.abs(ageDate.getUTCFullYear() - 1970);
//         return $(`<div class="participant-age">${age}</div>`);
//     };

//     const participantGender = () => {
//         return $(`<div class="participant-gender">${participant.gender}</div>`);
//     };

//     const participantTraining = () => {
//         const trainingType = participant.training_type;
//         const training = trainingType === 'צבאית' ? participant.training_number : participant.training_institution;
//         return $(`<div class="participant-training">${training}</div>`);
//     };

//     const participantFlexability = () => {
//         const isFlexible = participant.is_flexible;
//         return $(`<div class="participant-flexability"><input type="checkbox" ${isFlexible ? 'checked' : ''} value="1"/></div>`);
//     };

//     const participantStatus = () => {
//         const $statusesField = $('.acf-field[data-name="statuses"');
//         const statuses = $statusesField.find('tr.acf-row:not(.acf-clone)').map(function () {
//             const $row = $(this);
//             return {
//                 name: $row.find('td[data-name="status"] input').val(),
//                 color: $row.find('td[data-name="status_color"] input[type="hidden"]').val(),
//                 default: $row.find('td[data-name="default"] input[type="checkbox"]').prop('checked')
//             }
//         });
//         const $statusItem = $(`<div class="participant-status"></div>`);
//         let prticipantStatus = '';

//         if (participant.status) {
//             prticipantStatus = participant.status;
//         } else {
//             const defaultStatus = statuses.find(status => status.default);
//             prticipantStatus = defaultStatus.name;
//         }

//         const $statusSelect = $(`<select class="participant-status-select"></select>`);
//         Array.from(statuses).forEach(function (status) {
//             const $option = $(`<option value="${status.name}" data-color="${status.color}" ${status.name === prticipantStatus ? 'selected' : ''}>${status.name}</option>`);
//             $statusSelect.append($option);
//         });

//         $statusSelect.on('change', function () {
//             const selectedStatus = $(this).val();
//             const selectedColor = $(this).find(`option[value="${selectedStatus}"]`).data('color');
//             $(this).css('background-color', selectedColor);
//         });

//         $statusSelect.trigger('change');
//         $statusItem.append($statusSelect);
//         return $statusItem;
//     };

//     const participantContact = () => {
//         const $contactsField = $('.acf-field[data-name="contacts"');
//         const contacts = $contactsField.find('tr.acf-row:not(.acf-clone)').map(function () {
//             const $row = $(this);
//             return {
//                 name: $row.find('td[data-name="contact_name"] input').val(),
//             }
//         });
//         const participantContact = participant.contact ? participant.contact : '';
//         const $contactItem = $(`<div class="participant-contact"></div>`);
//         const $contactSelect = $(`<select class="participant-contact-select"></select>`);
//         const $emptyOption = $(`<option value="">בחר איש קשר</option>`);
//         $contactSelect.append($emptyOption);
//         Array.from(contacts).forEach(function (contact) {
//             const $option = $(`<option value="${contact.name}" ${contact.name === participantContact ? 'selected' : ''}>${contact.name}</option>`);
//             $contactSelect.append($option);
//         });

//         $contactItem.append($contactSelect);
//         return $contactItem;
//     };

//     const participantActions = () => {
//         const $actions = $(`<div class="participant-actions"></div>`);
//         const $save = $(`<button type="button" class="participant-action" data-action="save">שמירה</button>`);
//         const $remove = $(`<button type="button" class="participant-action" data-action="remove">מחיקה</button>`);
//         $actions.append($save, $remove);
//         $save.on('click', function () {
//             const $participant = $(this).closest('.participant');
//             saveParticipantData($participant, postID, departureDate, index);
//         });
//         return $actions;
//     };

//     $listItem.append(participantDetails());
//     $listItem.append(participantAge());
//     $listItem.append(participantGender());
//     $listItem.append(participantTraining());
//     $listItem.append(participantFlexability());
//     $listItem.append(participantStatus());
//     $listItem.append(participantContact());
//     $listItem.append(participantActions());
//     return $listItem;
// }

function saveParticipantData($participant, postID, departureDate, index) {
    const participantData = {
        is_flexible: $participant.find('.participant-flexability input').prop('checked'),
        status: $participant.find('.participant-status-select').val(),
        contact: $participant.find('.participant-contact-select').val()
    };

    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'save_participant_data',
            post_id: postID,
            departure_date: departureDate.split('/').join('-'),
            index,
            participant_data: participantData
        },
        success: function (response) {
            console.log(response);
        }
    });
}
