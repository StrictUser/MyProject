<?php
session_start();
header('Content-type:text/html; charset=UTF-8');

$sql = new mysqli('localhost', 'blogadmin', 'r5E2NQX5XRGdmevE') or die('Cannot connect to database');
$sql->select_db('blog') or die('Cannot select database');
$sql->set_charset('utf8');
mb_internal_encoding('UTF-8');

$action = isset($_GET['act']) ? $_GET['act'] : 'list';

define('IS_ADMIN', isset($_SESSION['IS_ADMIN']));

$records = array();

switch($action){
	
	case 'list':
		$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
		$limit = 5;
		$offset = ($page - 1) * $limit;
		$pages_result = $sql->query("SELECT COUNT(*) AS cnt FROM entry")->fetch_assoc();
		$pages = $pages_result['cnt'];
		$sel = $sql->query("SELECT entry.*, COUNT(comments.id) AS comments 
							FROM entry
							LEFT JOIN comments ON entry.id = comments.entry_id
							GROUP BY entry.id
							ORDER BY date DESC
							LIMIT $offset, $limit");
		while($row = $sel->fetch_assoc()){
			$row['date'] = date('d.m.Y H:i', $row['date']);
			if(mb_strlen($row['content']) > 60){
				$row['content'] = mb_substr(strip_tags($row['content']), 0, 57) . '...';
			}
			$row['header'] = htmlspecialchars($row['header']);
			$row['content'] = nl2br($row['content']);
			$records[] = $row;
		}
		require('templates/list.php');
		break;
	
	case 'view-entry':
		if(!isset($_GET['id'])) die('Missing id parameter!');
		$id = $_GET['id'];
		$entry = $sql->query("SELECT * FROM entry WHERE id = $id")->fetch_assoc();
		$entry['date'] = date('d.m.Y  H:i', $entry['date']);
		$entry['header'] = htmlspecialchars($entry['header']);
		$entry['content'] = nl2br($entry['content']);
		
		$comments = array();
		$sel = $sql->query("SELECT * FROM comments WHERE entry_id = $id ORDER BY date");
		while($row = $sel->fetch_assoc()){
			$row['date'] = date('d.m.Y  H:i', $row['date']);
			$row['author'] = htmlspecialchars($row['author']);
			$row['content'] = nl2br(htmlspecialchars($row['content']));
			$comments[] = $row;
		}
		
		require('templates/entry.php');
		break;

	case 'do-new-entry':
		if(!IS_ADMIN) die("<h3>You must be admin to add new article!</h3>");
		$sel = $sql->prepare("INSERT INTO entry(author, date, header, content) VALUES(?,?,?,?)");
		$dat = time();
		$sel->bind_param('siss', $_POST['author'], $dat, $_POST['header'], $_POST['content']);
		if($sel->execute()){
			header('Location: .');
		}else{
			die('Cannot insert article');
		}
		break;
		
	case 'delete-entry':
		if(!IS_ADMIN) die("<h3>You must be admin to delete the article!</h3>");
		$id = intval($_GET['id']);
		$sql->query("DELETE FROM entry WHERE id = $id") or die('Cannot delete article');
		$sql->query("DELETE FROM comments WHERE id = $id") or die('Cannot delete comment');
		header('Location: .');
		break;
		
	case 'edit-entry':
		if(!IS_ADMIN) die("<h3>You must be admin to edit the article!</h3>");
		$id = intval($_GET['id']);
		$row = $sql->query("SELECT * FROM entry WHERE id = $id")->fetch_assoc();
		require('templates/edit-entry.php');
		break;
		
	case 'apply-edit-entry':
		if(!IS_ADMIN) die("<h3>You must be admin to edit the article!</h3>");
		$sel = $sql->prepare("UPDATE entry SET author = ?, header = ?, content = ? WHERE id = ?");
		$id = intval($_POST['id']);
		$sel->bind_param('sssi', $_POST['author'], $_POST['header'], $_POST['content'], $id);
		if($sel->execute()){
			header('Location: .');
		}else{
			die('Cannot insert article');
		}
		break;
		
	case 'do-new-comment':
		$sel = $sql->prepare("INSERT INTO comments(entry_id, author, date, content) VALUES(?,?,?,?)");
		$dat = time();
		$sel->bind_param('isis', $_POST['entry_id'], $_POST['author'], $dat, $_POST['comment']);
		if($sel->execute()){
			header('Location: ?act=view-entry&id=' . intval($_POST['entry_id']));
		}else{
			die('Cannot insert comment');
		}
		break;
	case 'delete-comment':
		if(!IS_ADMIN) die("<h3>You must be admin to delete the comment!</h3>");
		$id = intval($_GET['id']);
		$sql->query("DELETE FROM comments WHERE id = $id") or die('Cannot delete comment');
		header('Location: ?act=view-entry&id=' . intval($_GET['entry_id']));
		break;
		
		
	case 'login':
		require('templates/login.php');
		break;
	
	case 'logout':
		unset($_SESSION['IS_ADMIN']);
		header('Location: .');
		break;
	
	case 'do-login':
		if($_POST['login'] == 'blogadmin' && $_POST['password'] == 'r5E2NQX5XRGdmevE'){
			$_SESSION['IS_ADMIN'] = TRUE;
			header('Location: .');
		}else{
			header('Location: ?act=login');
		}
		break;
	
	default:
		die("No such action");
}

?>