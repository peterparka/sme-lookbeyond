<?php
/**
 * Helper functions for twitter
 *
 * @see    http://wolfthemes.com/plugin/wolf-twitter/
 * @author wolfthemes
 */

/**
* Find url strings, tags and username strings and make them as link
*
* @param string $text
* @return string $text
*/
function twitter_to_link( $text ) {

// Match URLs
$text = preg_replace( '/(^|[^=\"\/])\b((?:\w+:\/\/|www\.)[^\s<]+)((?:\W+|\b)(?:[\s<]|$))/m', '<a href="$0" class="twitter-url" target="_blank">$0</a>', $text);

// Match @name
$text = preg_replace( '/(@)([a-zA-ZÀ-ú0-9\_]+)/', '<a href="https://twitter.com/$2" class="twitter-username" target="_blank">@$2</a>', $text);

// Match #hashtag
$text = preg_replace( '/(#)([a-zA-ZÀ-ú0-9\_]+)/', '<a href="https://twitter.com/search/?q=$2" class="twitter-hashtag" target="_blank">#$2</a>', $text);

return $text;
}

/**
* Convert the twitter date to "X ago" type
*
* @param string $date
* @return string $date
*/
function twitter_time_ago( $date ) {
$date = esc_html(
sprintf(
__( '%s ago' ), human_time_diff( strtotime( $date ), current_time( 'timestamp' ) )
)
);

return $date;
}
