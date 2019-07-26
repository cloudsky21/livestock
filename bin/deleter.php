<form action="" method="POST">
<p>Delete record?</p>
<input type="hidden" value="<?PHP echo htmlentities($_POST['rowid']); ?>" name="recorded">
<button type="submit" name="delete_form" class="btn btn-success">Submit</button>

</form>


