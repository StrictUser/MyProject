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
	
	.entry{
		padding-left: 10px;
	}
	
	h1{
		margin-bottom: 10px;
	}
	.pages{
		margin-bottom: 40px;
	}
	.icon{
		margin: 0px 20px 0px 20px;
	}
	
</style>

	<h1>Entries in my Blog</h1>
	<br />
	<?php foreach ($records as $row): ?>
	
		<div class="entry">
			<h3>
				<a href="?act=view-entry&id=<?=$row['id']?>"><?=$row['header']?></a>
				<?php if(IS_ADMIN): ?>
				<a href="?act=edit-entry&id=<?=$row['id']?>"><span class="icon"><i class="glyphicon glyphicon-pencil"></i></span></a>
				<a href="?act=delete-entry&id=<?=$row['id']?>"><span><i class="glyphicon glyphicon-remove"></i></span></a>
				<?php endif ?>
			</h3>
			<p class="content"><?=$row['content']?></p>
			<div class="comments">
				<span class="date"><?=$row['date']?></span>
				<span class="author">by  <b><?=$row['author']?></b></span>
				<span><a href="?act=view-entry&id=<?=$row['id']?>"><?=$row['comments'];?> comment(s)</a></span>
			</div>
		</div>
		<br />
	<?php endforeach ?>
	<br />

<div class="pages">
	Pages:
	<?php for($i = 1; $i < $pages; $i++): ?>
		<?php if($i == $pages): ?><b><?=$i?></b>
		<?php else: ?><a href="?page=<?=$i?>"><?=$i?></a>
		<?php endif ?>
	<?php endfor ?>
</div>
	
<article>
	<?php if (IS_ADMIN):?>
	<h2>Add new article</h2>
	<br>
	<form action="?act=do-new-entry" method="post" class="well">
		<div class="form-group form-group-sm">
		    <label>Author</label>
		    <input type="text" name="author" class="form-control" style="width: 300px;">
		</div>
		<div class="form-group form-group-sm">
		    <label>Header</label>
		    <input type="text" name="header" class="form-control">
		</div>
	    <label>Content</label>
	    <textarea class="form-control" rows="7" name="content"></textarea>
	    <button type="submit" class="btn btn-success" style="margin-top: 15px;">Add</button>
	</form>
	<?php endif; ?>
</article>

<?php require('footer.php') ?>