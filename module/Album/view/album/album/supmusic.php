<?php
$title = 'Supprimer Music '.$this->escapeHtml($album->title);
$this->headTitle($title);
?>
<h1><?php echo $this->escapeHtml($title); ?></h1>

<p>Voulez-vous Supprimer cette music ? 
	'<?php echo $this->escapeHtml($album->title); ?>' by
	'<?php echo $this->escapeHtml($album->artist); ?>'?
	
	toute les photo Associer a ce album vont supprimer aussi.
</p>
<?php
$url = $this->url('album', array('action' => 'supmusic','id' => $this->id,));
?>
<form action="<?php echo $url; ?>" method="post">
	<div>
		<input type="hidden" name="id" value="<?php echo (int) $album->id; ?>" />
		<input type="submit" name="del" value="Yes" />
		<input type="submit" name="del" value="No" />
	</div>
</form>
