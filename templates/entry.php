<?php require('header.php') ?>

<style>
	.date, .author{
		margin-right: 20px;
	}
	
	.comments{
		font-size: 0.8em;
		margin-bottom: 20px;
	}
	
	.content{
		padding-top: 5px;
		padding-left: 15px;
	}
	
	h2{
		margin-bottom: 10px;
	}
	
</style>

	<h2><?=$entry['header']?></h2>
	<p class="content"><?=$entry['content']?></p>
	<div class="comments">
		<span class="date"><?=$entry['date']?></span>
		<span class="author">by <?=$entry['author']?></span>
		<span><a href="?act=view-entry&id=<?=$entry['id']?>">Comments</a></span>
	</div>
	<br>
	<h2>Comments:</h2>

	<?php foreach ($comments as $row): ?>
	
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="date"><?=$row['date']?></span>
				<span class="author">by <b><i><?=$row['author']?></i></b></span>
				<a href="?act=delete-comment&entry_id=<?=$entry['id']?>&id=<?=$row['id']?>"><span><i class="glyphicon glyphicon-remove"></i></span></a>
			</div>
			<p class="content"><?=$row['content']?></p>
		</div>

	<?php endforeach ?>
	<br>
	<h3>Add new comment</h3>
	<br>
	<form action="?act=do-new-comment" method="post" class="well">
		<input type="hidden" name="entry_id" value="<?=$id?>">
		<div class="form-group form-group-sm" style="width: 300px;">
		    <label>Author</label>
		    <input type="text" name="author" class="form-control">
		</div>
	    <label>Comment</label>
	    <textarea class="form-control" rows="7" name="comment" style="width: 300px;"></textarea>
	    <div style="margin-top: 10px;">    
	      <button type="submit" class="btn btn-success">Add</button>    
	    </div>
	</form>

<?php require('footer.php') ?>