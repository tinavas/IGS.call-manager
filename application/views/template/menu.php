			<ul>
			<?php foreach ($menu as $item=>$link) : ?>
				<li><a href="<?php echo base_url().$link; ?>"><?php echo $item; ?></a></li>
      		<?php endforeach;?>
      		</ul>