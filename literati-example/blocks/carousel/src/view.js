/**
 * Use this file for JavaScript code that you want to run in the front-end
 * on posts/pages that contain this block.
 *
 * When this file is defined as the value of the `viewScript` property
 * in `block.json` it will be enqueued on the front end of the site.
 *
 * Example:
 *
 * ```js
 * {
 *   "viewScript": "file:./view.js"
 * }
 * ```
 *
 * If you're not making any changes to this file because your project doesn't need any
 * JavaScript running in the front-end, then you should delete this file and remove
 * the `viewScript` property from `block.json`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-metadata/#view-script
 */

/* eslint-disable no-console */
import Splide from '@splidejs/splide';

// Import our default css theme for splide
import '@splidejs/splide/css';

// This should only be output on the frontend of the site - NOT the editor
console.log("hello from the frontend.")

document.addEventListener( 'DOMContentLoaded', () => {

    // Splide
    const splides = document.querySelectorAll('.splide')

    if(!!splides && splides.length > 0){
        splides.forEach(splide => {
            // Grab the slide interval and convert it to an integer and milliseconds
            const interval = parseInt(splide.dataset.interval) * 1000

            new Splide(splide, {
                type: 'loop',
                autoplay: true,
                pagination: false,
                focus: "center",
                perPage: 1,
                perMove: 1,
                pauseOnHover: false,
                interval: interval,
                padding: '20rem',
            }).mount()
        })
    }
})
/* eslint-enable no-console */
