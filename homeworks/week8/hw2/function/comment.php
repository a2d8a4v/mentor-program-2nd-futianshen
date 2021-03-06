<?php
/* connect to database */
require_once('conn.php');
session_start();
$user_id = $_SESSION['user_id'];

/* create comment */
if (isset($_POST['post_id']) && isset($_POST['comment_content'])) {
    $post_id = $_POST['post_id'];
    $comment_content = $_POST['comment_content'];

    $create_comment = $conn->prepare("INSERT INTO tian_comments VALUES(NULL, CURRENT_TIMESTAMP, ?, ?, ? , 0)");
    $create_comment->bind_param("iis", $user_id, $post_id, $comment_content);
    $create_comment->execute() or die(header('Location: signup.php')); 

    /* read post_user_id */
    $read_post = $conn->prepare("SELECT tian_posts.user_id FROM tian_posts WHERE id=?");
    $read_post->bind_param("i", $post_id);
    $read_post->execute() or die;
    $read_post_result = $read_post->get_result();
    $read_post_row = $read_post_result->fetch_assoc();
    $post_user_id = $read_post_row['user_id'];

    /* prepare comment to front-end */
    $read_comment = $conn->prepare("SELECT tian_comments.id, tian_comments.created_at, tian_comments.user_id, tian_users.nickname 
    FROM tian_comments LEFT JOIN tian_users ON tian_comments.user_id = tian_users.id 
    ORDER BY tian_comments.id DESC");
    $read_comment->execute();
    $read_comment_result = $read_comment->get_result();
    $read_comment_row = $read_comment_result->fetch_array();
    $comment_nickname=$read_comment_row['nickname'];
    $comment_time=$read_comment_row['created_at'];
    $comment_id = $read_comment_row['id'];
    $conn->close(); 

    /* send response to front-end */
    $arr = array( 
        'result' => 'success',
        'highlight' => $post_user_id===$user_id,
        'comment_id' => $comment_id,
        'comment_nickname' => $comment_nickname,
        'comment_time' => $comment_time 
    ); 
    echo json_encode($arr); /* 要有 echo 才行 */
} 
?> 