<?php $this->load->view('Layouts/header'); ?>
<h2 class="bg-primary text-center" style="padding: 10px">All Products</h2>
<?php  if($msg=$this->session->flashdata('msg')):
$msg_class=$this->session->flashdata('msg_class')
?>
<div class="alert <?= $msg_class ?>">
	<?= $msg; ?>
</div>
<?php endif; ?>
<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover">
		<thead>
		<tr>
			<th class="text-center">#</th>
			<th class="text-center">Product Name</th>
			<th class="text-center">Product Image</th>
			<th class="text-center">Product Category</th>
			<th class="text-center">Product Price</th>
			<th class="text-center">Action</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($products as $key => $product): ?>
		<tr>
			<td class="text-center"><?=$key+1?></td>
			<td><?=$product->product_name; ?></td>
			<td class="text-center"><img height="40px" width="70px" src="<?=base_url('uploads/'.$product->image); ?>" alt="<?=$product->product_name; ?>"></td>
			<td><?=$product->cat_name; ?></td>
			<td><?=$product->product_price; ?></td>
			<td class="text-center">
				<?=
				form_open('product/delete', array('id'=>'delete-form-'.$product->id, 'style'=>'display: none;')),
				form_hidden('id', $product->id)
				?>
				<?=form_close(); ?>
				<a href="<?=base_url('product/edit/'.$product->id)?>" class="btn btn-success btn-sm">
					<span class="glyphicon glyphicon-edit"> </span>
				</a>
				<button type="submit" class="btn btn-danger btn-sm" onclick="if(confirm('Are you Sure, You went to delete this?')){
				event.preventDefault();
				document.getElementById('delete-form-<?=$product->id?>').submit();
				}else{
				event.preventDefault();
				}"><span class="glyphicon glyphicon-trash"></span></button>
			</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php echo $this->pagination->create_links(); ?>
</div>
<?php $this->load->view('Layouts/footer'); ?>
