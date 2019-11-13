		</div>
	</div>
	<div class="row">
		<div id="footer" class="col-xs-12">
			2013 - <?php echo date('Y') ?> &copy; <a href="http://www.e2edesign.com/">E2EDeseign</a>
		</div>
	</div>
</body>
<div class="modal fade delete-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo showLang($lang, 'DELETE_TITLE') ?></h4>
			</div>
			<div class="modal-body"><p></p></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo showLang($lang, 'CANCEL_CHANGES') ?></button>
				<a type="button" class="btn btn-danger delete-btn"><?php echo showLang($lang, 'DELETE_BTN') ?></a>
			</div>
		</div>
	</div>
</div>
<input type="file" id="upload" style="display: none;">
</html>