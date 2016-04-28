<?php

    $reddit_feed = reddit_feed('http://www.reddit.com/r/askscience+science/.rss');
    $reddit_feed = parse_feed($reddit_feed);
    
    
function reddit_feed($rss) {
    
    $reddit = new domDocument;
    $reddit->load($rss);

    $feed = array();

    foreach ($reddit->getElementsByTagName('entry') as $entry) {
        $output = array(
                        'title'   => $entry->getElementsByTagName('title')->item(0)->nodeValue,
                        'link'    => $entry->getElementsByTagName('link')->item(0)->getAttribute('href'),
                        'content' => $entry->getElementsByTagName('content')->item(0)->nodeValue
                  );
                  
        $token = '&#32; submitted by &#32;  /u/';
        $output['content'] = substr($output['content'], 0, strpos($output['content'], $token));
    
        $feed[] = $output;
    }
    
    return $feed;
}

function parse_feed($feed) {
    $title_len = 80;
    $content_len = 180;
    
    $output = '<ul>';
    
    foreach ($feed as $entry) {
        if (strlen($entry['title']) >= $title_len) $entry['title'] = substr($entry['title'], 0, $title_len) . '...';
            
        $entry['content'] = strip_tags($entry['content']);
        $entry['content'] = substr($entry['content'], 0, $content_len);
            
        $output .= '<li><a href="' . $entry['link'] . '">' . $entry['title'] . '</a>';
        $output .= $entry['content'];
        
    }
    
    $output .= '</ul>';
    
    return $output;
}

?>
