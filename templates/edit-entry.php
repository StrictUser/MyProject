<?php require('header.php') ?>

<article>
	<?php if (IS_ADMIN):?>
	<h2>Add new article</h2>
	<br>
	<form action="?act=apply-edit-entry" method="post" class="well">
		<input type="hidden" name="id" value="<?=$id?>"/>
		<div class="form-group form-group-sm">
		    <label>Author</label>
		    <input type="text" name="author" class="form-control" style="width: 300px;" value="<?=$row['author']?>" />
		</div>
		<div class="form-group form-group-sm">
		    <label>Header</label>
		    <input type="text" name="header" class="form-control" value="<?=$row['header']?>" />
		</div>
	    <label>Content</label>
	    <textarea class="form-control" rows="7" name="content"><?=$row['content']?></textarea>
	    <button type="submit" class="btn btn-success" style="margin-top: 15px;">Save</button>
	</form>
	<?php endif; ?>
</article>

<?php require('footer.php') ?>