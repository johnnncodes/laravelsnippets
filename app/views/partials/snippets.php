<?php if ( count( $snippets ) > 0 ): ?>

	<div class="table-responsive">
		<table class="table snippets-table">
			<thead>
				<tr>
					<th class="textleft">Snippet</th>
					<th>Posted</th>
					<th><i class="fa fa-eye"></i></th>
					<th><i class="fa fa-comments"></i></th>
					<th><i class="fa fa-star"></i></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($snippets as $snippet): ?>

					<tr class="snippet">
						<td class="textleft"><a href="<?php echo route('snippet.getShow', $snippet->slug); ?>"><?php echo e($snippet->title); ?></a></td>
						<td><?php echo $snippet->humanCreatedAt; ?></td>
						<td><?php echo $snippet->hasHits() ? $snippet->hits : '0'; ?></td>
						<td><?php echo $snippet->comments ? $snippet->comments : '0'; ?></td>
						<td><?php echo $snippet->starred->count(); ?></td>
					</tr>

				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

<?php else: ?>

	<p>No snippets available.</p>

<?php endif; ?>