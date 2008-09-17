<? $this->load->view('emb_header')?>
		
		<?php if ($flash_msg = $this->session->flashdata('flash_msg')): ?>
			<div class="flash-msg"><?=$flash_msg;?></div>
		<?php endif ?>

<!-- 		<h2 class="first">Write a note</h2>
		<form id="letter-form" action="<?=site_url('/site/add')?>" method="POST">
			<textarea name="letter" id="letter" rows="8" cols="40"></textarea>
			<input type="submit" name="submit" value="Add" id="submit" />
		</form> -->
		
		<h2>Popular notes</h2>
		<ul id="recent-entries">
			<?php foreach ($rows as $row): ?>
				<li class="letter">
					<div class="body">
						<h3>Dear Zend,</h3>
						<p><?=$row->body?></p>
					</div>
					<div class="meta">
						<div class="posted"><a href="<?=site_url('/site/single/'.$row->id)?>">Posted <?=$row->posted?></a></div>
						<div class="favorite">Liked by <?=$row->favorite_count?> person(s). <a href="<?=site_url('/site/favorite/'.$row->id)?>">I like this</a></div>
					</div>
				</li>
			<?php endforeach ?>
		</ul>

<? $this->load->view('emb_footer')?>		
