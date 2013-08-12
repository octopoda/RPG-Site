<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	$contentsers = new Users();

	if (!empty($_GET['sel'])) {
		$archive = new Archive($_GET['sel']);
		$archive->buildArticleList();
	} else {
		echo '<h3>No Archive Selected.</h3>';
		return;
	}

?>

<ul class="quickMenu">
	<li>
    	<a href="forms/archives/form_archives.php?sel=<?php echo $archive->archive_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span>
        	<span class="text">Edit Issue</span>
         </a>
    </li>
    <li><a href="forms/articles/form_articles.php?arc=<?php echo $archive->archive_id; ?>" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolPlus"></span>
        	<span class="text">Add Article</span>
         </a>
    </li>
</ul>

<hgroup>
<h3 class="floatLeft"><?php echo $archive->archive_title; ?></h3>
<ul class="archiveInfo">
	<li><strong>Volume:</strong><?php echo $archive->volume; ?></li>
    <li><strong>Issue:</strong><?php echo $archive->issue; ?></li>
    <li><strong>Date Published:</strong> <?php echo $archive->setDate(); ?></li>
	<li><strong>File: </strong><?php echo ($archive->archive_link != NULL) ? $archive->archive_link : 'There is no file associated with this archive.'; ?></li>
</ul>
</hgroup>
<div class="articleListing">
	<h3>Articles for <?php echo $archive->archive_title; ?></h3>

	<?php  if ($archive->articleList == false) { ?>
		<p>The are no articles asssociated with this issue.</p>
	<?php } else { ?>

	<?php foreach ($archive->articleList as $article) {  ?>
			<div class="article">
            	<hgroup>
                    <h5 class="articleTitle"><?php echo $article->article_title; ?></h5>
                </hgroup>

                <ul class="articleEdit">
                    <li><?php echo $article->published($article->article_id); ?></li>
                    <li><a class="delete ninjaSymbol ninjaSymbolClear" id="article" sel="<?php echo $article->article_id; ?>" href="forms/archives/list_archives.php?sel=<?php echo $archive->archive_title; ?>"></a></li>
                    <li><a class="edit ninjaSymbol ninjaSymbolEdit" id="article" sel="<?php echo $article->article_id; ?>" href="forms/articles/form_articles.php?sel=<?php echo $article->article_id; ?>&arc=<?php echo $archive->archive_id; ?>"></a></li>
                </ul>
                <div class="articleInfo">
                    <p><strong>Author:</strong></p>
                    <p><?php echo $article->author; ?></p>
                    <p><strong>File:</strong></p>
                    <p><?php echo $article->article_link; ?></p>

                    <p><strong>Description</strong></p>
                    <p><?php echo $article->description; ?></p>

                    <p><strong>Topics</strong></p>
                    <p><?php echo ($article->listCategories() != NULL) ? $article->listCategories() : 'There are no categories associated with this article'; ?></p>
             	</div>
             </div>
	<?php } ?>

    <?php } ?>
</div>

<script>
$(function () {
	$('.articleInfo').hide();
	$('.articleTitle').append('<span> <-- Click to Expand</span>');

	$('.articleTitle').click(function (e) {
		_this = $(this);
		_span = _this.children('span');
		_info = $(this).parent('hgroup').parent('div').children('.articleInfo');

		if (_this.hasClass('open')) {
			_span.remove();
			_this.append('<span> <-- Click to Expand</span>');
			_info.slideUp(500);
		} else {
			_span.remove();
			_this.append('<span> <-- Click to Minimize</span>');
			_info.slideDown(500);
		}

		_this.toggleClass('open');
	})
});
</script>
