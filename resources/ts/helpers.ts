import Swal from 'sweetalert2';
import dayjs from 'dayjs';
import numeral from 'numeral'
import relativeTime from "dayjs/plugin/relativeTime";
dayjs.extend(relativeTime);

/**
 * convert snake case to sentence case, capitalizing all words
 * eg 'your_string' => 'Your String'
 */
export const snakeCaseToSentenceCaseCapitalizeWords = (value: string | null) => {
    if (!value) return "";
    value = value.replace(/(_)/g, " ");
    return value.replace(/\b\w/g, function (l) {
        return l.toUpperCase();
    });
};


/**
 * format a date
 * @param dt Date
 * @param format string
 * @returns string
 */
export const formatDate = (dt: Date | null | undefined, format = 'DD MMMM, YYYY') => {
    if (!dt) return null;
    return dayjs(dt).format(format);
}

/**
 * format a date and cinldue time by default
 * @param dt Date
 * @param format string
 * @returns string
 */
export const formatDateTime = (dt: Date | null | undefined, format = 'DD MMMM, YYYY HH:mm a') => {
    if (!dt) return null;
    return dayjs(dt).format(format);
}


/**
 * generate a random string
 * @param length number
 * @returns string
 */
export const randomString = (length = 6) => {
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
};

/**
 * return 24-hour time from an  ISO 8601  date
 * @param date string
 * @returns string
 */
export const getTimeFromDate = (date: string | Date) => {
    return dayjs(date).format('HH:mm');
};

/**
 * generate a random number
 * @param min number
 * @param max number
 * @returns number
 */
export const randomNumber = (min = 0, max = 10000) => {
    return Math.floor(Math.random() * max) + min;
};

/**
 * get default avatar link
 * @param name string
 * @returns string
 */
export function getDefaultAvatarLink(name = "AKA") {
    return `https://ui-avatars.com/api/?name=${name}`;
}

// date => 2 days ago
export const fromNow = (date: Date | null | undefined) => {
    if (!date) return "";
    return dayjs(date).fromNow(); // { addSuffix: true }
};

// date => 22nd Jun 2021, 2:00 pm
// https://day.js.org/docs/en/display/format
export const dateFormat = (date: Date | null | undefined, dateFormat = "MMM D, YYYY h:mm A") => {
    if (!date) return "";
    return dayjs(date).format(dateFormat);
};

export const ucwords = (str: string): string => str.substring(0, 1).toUpperCase() + str.substring(1)


export const confirmAction = (message: string, callback: VoidFunction, cancelledCallback?: VoidFunction) => {
    Swal.fire({
        // title: 'Are you sure?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Proceed!',
        cancelButtonText: 'No',
        showClass: {
            popup: 'transition-all motion-reduce:transition-none ease-out duration-500 -translate-y-4 opacity-1'
        },
        // hideClass: {
        // 	popup: 'transition-all motion-reduce:transition-none ease-out translate-y-4 opacity-0 hidden'
        // },
    }).then((result) => {
        if (result.value) {
            callback();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            if (cancelledCallback) {
                cancelledCallback()
            }
        }
    });
}

export const numberFormat = (value: string | number): string => {
    if (isNaN(value)) return ""
    return numeral(value).format("0,0.00") // becomes 1,000.00 | displaying other groupings/separators is possible, look at the docs http://numeraljs.com/
}

export const numberFormatInt = (value: string | number): string => {
    if (isNaN(value)) return ""
    return numeral(value).format("0,0") // becomes 1,000 | displaying other groupings/separators is possible, look at the docs http://numeraljs.com/
}

/**
 * slugify a string
 *
 * @param str string
 * @returns string
 */
export const slugify = (str: string) => {
    return str
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

/**
 * strip html tags an dimg tags from a html string
 * @param htmlString string
 * @returns string
 */
export const stripTags = (htmlString: string) => {
    return htmlString.replaceAll(/(<([^>]+)>)/gi, '').replace(/<img[^>]*>/gi, '');
}


/**
 * throw validation error from zod
 * @param errors array,object,string
 * @param code number default=422
 */
export const getValidationErrorMessages = (errors: Error | string | string[]): string[] | null => {
    if (Array.isArray(errors)) {
        const arr: string[] = []
        errors.forEach(e => arr.push(snakeCaseToSentenceCaseCapitalizeWords(e)))
        return arr;
    }

    if (typeof errors === 'object') {
        if (Object.keys(errors).length < 1) {
            return null;
        }

        return Object.values(errors)
    }

    return [errors.toString()]
}

/**
 * verifie si la chaine renseigné est un email
 * check if email is valide
 * @param string emailAdress
 * @return bool
 */
export function isEmail(emailAdress: string | null | undefined): boolean {
    if (!emailAdress) return false;

    let regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

    if (emailAdress.match(regex))
        return true;

    else
        return false;
}
