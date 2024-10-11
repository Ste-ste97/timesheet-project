import moment from 'moment-timezone';

export function convertDateString(date) {
    if (moment(date).isValid() === false) {
        return "";
    }

    return moment(date).format('YYYY-MM-DD');
}

export function formatDate(dateInput) {
    if (moment(dateInput).isValid() === false) {
        return dateInput;
    }

    return moment(dateInput).format('DD-MM-YYYY');
}

export function formatDateTime(dateTime) {
    return moment(dateTime).format('DD/MM/YYYY HH:mm:ss');
}

export function formatTime(dateTime) {
    return moment(dateTime).format('HH:mm:ss');
}