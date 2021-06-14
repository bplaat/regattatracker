const csrfToken = window.data.csrfToken;
const apiKey = window.data.apiKey;
const apiToken = window.data.apiToken;
const eventData = window.data.event;
const eventClassFleetBoats = window.data.eventClassFleetBoats;
const links = window.data.links;
const strings = window.data.strings;

let timeType = 'started_at';

const timeForm = document.getElementById('time_form');
const timeTypeInput = document.getElementById('time_type');
const boatThingInput = document.getElementById('boat_thing');
const timeLabel = document.getElementById('time_label');
const timeInput = document.getElementById('time');

function parseDateTime(dateTime) {
    if (dateTime != '') {
        return dateTime.replace('T', ' ').split('.')[0];
    }
    return '';
}

timeForm.addEventListener('submit', event => {
    event.preventDefault();

    const dateDate = new Date();
    const dateValue = dateDate.getFullYear() + '-' + String(dateDate.getMonth()).padStart(2, '0') + '-' + String(dateDate.getDay()).padStart(2, '0');

    const timeValue = timeInput.value.slice(0, 2) + ':' + timeInput.value.slice(2, 4) + ':' + timeInput.value.slice(4, 6);

    for (const boat of eventClassFleetBoats) {
        if (boat.id == boatThingInput.value || boat.mmsi == boatThingInput.value || boat.sail_number == boatThingInput.value) {
            fetch(links.apiEventClassFleetBoatsUpdate.replace('{event}', eventData.id).replace('{eventClass}', boat.pivot.event_class_id)
                .replace('{eventClassFleet}', boat.pivot.event_class_fleet_id).replace('{boat}', boat.id), {
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Authorization': 'Bearer ' + apiToken,
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'api_key=' + apiKey + '&' + timeType + '_date=' + dateValue + '&' + timeType + '_time=' + timeValue +
                    (timeType == 'started_at' ? '&finished_at_date=' + parseDateTime(boat.pivot.finished_at).split(' ')[0] + '&finished_at_time=' + parseDateTime(boat.pivot.finished_at).split(' ')[1] :
                    '&started_at_date=' + parseDateTime(boat.pivot.started_at).split(' ')[0] + '&started_at_time=' + parseDateTime(boat.pivot.started_at).split(' ')[1])
            })
            .then(response => response.json())
            .then(data => {
                if (timeType == 'started_at') {
                    boat.pivot.started_at = data.pivot.started_at;
                    document.getElementById('boat_row_' + boat.id).children[4].textContent = parseDateTime(data.pivot.started_at);
                }

                if (timeType == 'finished_at') {
                    boat.pivot.finished_at = data.pivot.finished_at;
                    document.getElementById('boat_row_' + boat.id).children[5].textContent = parseDateTime(data.pivot.finished_at);
                }
            });

            break;
        }
    }

    boatThingInput.value = '';
    timeInput.value = '';
    boatThingInput.focus();
});

timeTypeInput.addEventListener('change', event => {
    timeType = timeTypeInput.value;

    if (timeType == 'started_at') {
        timeLabel.textContent = strings.started_at;
    }
    if (timeType == 'finished_at') {
        timeLabel.textContent = strings.finished_at;
    }
});
