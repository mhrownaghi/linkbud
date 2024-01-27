import { getOther } from '@/socials/other';
import { getInstagram } from '@/socials/instagram';
import { getReddit } from '@/socials/reddit';
import { getTwitter } from '@/socials/twitter';

function getDomain(url) {
    return new URL(url).hostname.split('.').at(-2)
}

function getLink({ name, url }) {
    switch (getDomain(url)) {
        case 'twitter':
            return getTwitter({ name, url });
        case 'reddit':
            return getReddit({ name, url });
        case 'instagram':
            return getInstagram({ name, url });
        default:
            return getOther({ name, url });
    }
}

export { getLink }