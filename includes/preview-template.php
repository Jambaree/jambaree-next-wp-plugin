<?php wp_head();

global $post;

console_log(['post' => $post]);

$post_id = $post->ID;
$url = get_permalink($post);
$slug = str_replace(home_url(), "", $url);

$revision = array_values(wp_get_post_revisions($post_id))[0] ?? null;

console_log(['url' => $url]);
console_log(['slug' => $slug]);
console_log(['revision' => $revision]);

$revision_id;

if (isset($revision)) {
    $revision_id = $revision->ID;
}


console_log(['revision_id' => $revision_id]);


if (function_exists('graphql')) {
    $graphql = graphql([
        'query' => "{
                                viewer {
                                    jwtAuthToken
                                }
                            }"
    ]);

    $jwtAuthToken;


    if (isset($graphql)) {
        $jwtAuthToken = $graphql['data']['viewer']['jwtAuthToken'];
    }
}



?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Preview</title>
    <style>
        iframe {
            position: fixed;
            top: 32px;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <?php $frontend_url = get_field('jambaree_frontend_url', 'option'); ?>
    <?php $frontend_url_trailing_slash = rtrim($frontend_url, '/') . '/'; ?>
    <?php $frontend_url_no_trailing_slash = rtrim($frontend_url, '/'); ?>

    <?php if ($frontend_url) : ?>
        <iframe id='preview' src="<?= $frontend_url_trailing_slash;
                                    ?>preview?key=<?= $jwtAuthToken; ?>&slug=<?= $slug ?>&revision_id=<?= $revision_id ?>&no-cache=1" frameborder="0"></iframe>
    <?php endif; ?>
</body>

</html>
<?php wp_footer(); ?>