var dayjs = require("dayjs");
var relativeTime = require("dayjs/plugin/relativeTime");
var isBetween = require("dayjs/plugin/isBetween");
dayjs.extend(isBetween);

function getTimeAgo(date) {
    dayjs.extend(relativeTime);
    return dayjs(new Date(date)).fromNow();
}

function formatDate(date) {
    return dayjs(new Date(date)).format("MMM DD, YYYY");
}

export default { getTimeAgo, formatDate };
