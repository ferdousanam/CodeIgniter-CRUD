<?php $this->load->view('Layouts/header'); ?>
<h2 class="bg-primary text-center" style="padding: 10px">Update Product</h2>
<div style="padding-bottom: 15px">
<?php foreach ($product as $product):?>
<?php echo form_open_multipart('product/edit/'.$product->id); ?>
<div class="form-group">
	<label>Product Name</label>
	<div class="text-danger"><?php echo form_error('product_name');  ?></div>
	<?php echo form_input('product_name', $product->product_name, array('class'=>'form-control','id'=>'product_name', 'placeholder'=>'Enter Product Name')); ?>
</div>
<div class="form-group">
	<label>Product Category</label>
	<div class="text-danger"><?php echo form_error('product_category');  ?></div>
	<select name="product_category" class="form-control">
		<?php foreach ($categories as $category): ?>
			<option value="<?=$category->id?>" <?php if ($category->id == $product->cat_id) echo 'selected';?>><?=$category->cat_name?></option>
		<?php endforeach; ?>
	</select>
</div>
<div class="form-group">
	<label>Product Price</label>
	<div class="text-danger"><?php echo form_error('product_price');  ?></div>
	<?php echo form_input('product_price', $product->product_price, array('class'=>'form-control','id'=>'product_price', 'placeholder'=>'Enter Product Price')); ?>
</div>
<div class="form-group">
	<label>Product Image</label>
	<div class="text-danger"><?php if (isset($upload_error)) {echo $upload_error; };  ?></div>
	<?php echo form_upload('product_image', '', array('class'=>'form-control','id'=>'product_image')); ?>
</div>
<?php echo form_submit('submit', 'Submit', array('class'=>'btn btn-warning')); ?>
<?php echo form_close(); ?>
<?php endforeach; ?>
</div>
<?php $this->load->view('Layouts/footer'); ?>
