<?php

//get latest tag that starts with 'thepoint_'
$term = $wpdb->get_row('SELECT
    term_id,
    slug
  FROM wpaxzy_terms
  WHERE slug LIKE "thepoint_%"
  ORDER BY slug DESC LIMIT 1');

//build title for page
$month = substr($term->slug, 13, 2);
$year = substr($term->slug, 9, 4);
$title = 'The Point: ' . date('F Y', strtotime($year . '-' . $month));

//start page output
$page = '
<!doctype html>
<html lang="en">
  <head>
    <title>' . $title . '</title>
    ' . wp_head() . '
    <style type="text/css">
      body { background-color: white; padding: 2rem; }
      section { margin: 3rem auto; max-width: 800px; }
      header { display:flex;flex-direction:column;align-items:center }
      header a.noslimstat img { margin: 0 !important; }
      header img.point-logo { max-width: 700px; height: auto; }
      header h1 { font-size: 2rem; margin: .5rem; }
      header h5 { margin: 0 0 1rem; }
      #Smallchat { display: none; }
    </style>
  </head>
  <body>
    <section>
      <header>';

//show print-friendly
if (function_exists('pf_show_link')) {
    $page .= pf_show_link();
}

//front page
$post = get_post(555264);

$page .= '
        <h1>' . $title . '</h1>
        <div>
          ' . $post->post_content . '
        </div>
      </header>';

//get all posts
$posts = $wpdb->get_results('SELECT
    p.ID,
    p.post_date,
    p.post_title,
    p.post_content
  FROM wpaxzy_posts p
  JOIN wpaxzy_term_relationships r ON p.ID = r.object_id
  JOIN wpaxzy_term_taxonomy x ON r.term_taxonomy_id = x.term_taxonomy_id
  WHERE p.post_type = "post"
    AND p.post_status = "publish"
    AND x.term_id = ' . $term->term_id . '
  ORDER BY p.menu_order');

foreach ($posts as $post) {
    $page .= '<article>
    <h2>' . $post->post_title . '</h2>' .
    $post->post_content .
        '</article>';
}

$page .= '</section>
    <script>
      $(function(){
        $(".printfriendly a").click();
      });
    </script>
  </body>
</html>';

echo $page;

///die(get_tag_link($point_term_id));
