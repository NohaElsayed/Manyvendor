
<?php $__env->startSection('title'); ?> Product list
<?php $__env->stopSection(); ?>
<?php $__env->startSection('parentPageTitle', 'All Products'); ?>
<?php $__env->startSection('content'); ?>
    <?php if(!request()->is('dashboard/request/product/index')): ?>
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">Products List</h2>
            </div>
            <div class="float-right">
                <?php if(ProductExportImportActive() == 'YES'): ?>
                    <div class="row text-right">
                        <a href="#!" onclick="forModal('<?php echo e(route('admin.product.bydate')); ?>', 'Export By Date')" class="btn btn-export mr-3">Export By Date</a>
                        <a href="#!" onclick="forModal('<?php echo e(route('admin.product.bycategory', 'Export By Category')); ?>')" class="btn btn-export mr-3">Export By Category</a>
                        <a href="#!" onclick="forModal('<?php echo e(route('admin.product.bybrand', 'Export By Brand')); ?>')" class="btn btn-export mr-3">Export By Brand</a>
                        <?php if(vendorActive()): ?>
                            <a href="#!" onclick="forModal('<?php echo e(route('admin.product.byseller', 'Export By Seller')); ?>')" class="btn btn-export mr-3">Export By Seller</a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin.product.export')); ?>" class="btn btn-export mr-3">Export CSV</a>
                        <a href="<?php echo e(route('admin.product.blank.csv')); ?>" class="btn btn-export mr-3">Sample CSV</a>
                        <a href="#!" onclick="forModal('<?php echo e(route('admin.product.import')); ?>', 'Import')" class="btn btn-export">Import CSV</a>
                    </div>
                <?php else: ?>

                <div class="row text-right">
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-center table-sm">
                    <thead>
                    <tr>
                        <th>S/L</th>
                        <th class="text-left">Title</th>
                        <th>Details</th>
                        <th>Published</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e(($loop->index+1) + ($products->currentPage() - 1)*$products->perPage()); ?></td>
                            <td class="text-left">
                             <p class="text-bold"><?php echo e($item->name); ?></p>
                                <img src="<?php echo e(filePath($item->image)); ?>" height="80" width="100">
                            </td>

                            <td class="">
                                <p>Brand :<span class="text-bold"><?php echo e($item->brand->name); ?></span></p>
                                <p> Parent Category : <span class="text-bold"><?php echo e($item->category->name); ?></span>
                                <p> Sub Category : <span class="text-bold"><?php echo e($item->childcategory->name); ?></span>
                                    <?php if(vendorActive()): ?>
                                        <?php if($item->childcategory->commission != null): ?>
                                            <span class="badge badge-info"><?php echo e($item->childcategory->commission->amount); ?> %</span>
                                        <?php else: ?>
                                            <span class="badge badge-info"> Commission is not selected</span>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                </p>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input data-id="<?php echo e($item->id); ?>"
                                               <?php echo e($item->is_published == true ? 'checked' : null); ?>  data-url="<?php echo e(route('admin.product.published')); ?>"
                                               type="checkbox" class="custom-control-input"
                                               id="is_published_<?php echo e($item->id); ?>">
                                        <label class="custom-control-label" for="is_published_<?php echo e($item->id); ?>"></label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                            data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a  href="<?php echo e(route('admin.products.edit', [$item->id,$item->slug])); ?>" class="nav-link text-black">Edit</a>
                                        </li>
                                        <?php if(!vendorActive()): ?>
                                            <li>
                                                <a  href="<?php echo e(route('product.step.tow.edit', [$item->id,$item->slug])); ?>" class="nav-link text-black">Stock Add</a>
                                            </li>
                                        <?php endif; ?>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#!" class="nav-link text-black"
                                               onclick="confirm_modal('<?php echo e(route('admin.products.destroy', $item->id)); ?>')">Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6"><h3 class="text-center" >No Data Found</h3></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                    <div class="float-left">
                        <?php echo e($products->links()); ?>

                    </div>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if(request()->is('dashboard/request/product/index')): ?>
    <?php if(vendorActive()): ?>
    <div class="card m-2">
        <div class="card-header">
            <div class="float-left">
                <h2 class="card-title">Request products List</h2>
            </div>
            <div class="float-right">
                <div class="row text-right">
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-center table-sm">
                    <thead>
                    <tr>
                        <th>S/L</th>
                        <th class="text-left">Title</th>
                        <th>Details</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $requestProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e(($loop->index+1) + ($requestProducts->currentPage() - 1)*$requestProducts->perPage()); ?></td>
                            <td class="text-left">
                                <p class="text-bold"><?php echo e($item->name); ?></p>
                                <img src="<?php echo e(filePath($item->image)); ?>" height="80" width="100">
                            </td>

                            <td class="">
                                <p>Brand :<span class="text-bold"><?php echo e($item->brand->name); ?></span></p>
                                <p> Parent Category : <span class="text-bold"><?php echo e($item->category->name); ?></span>
                                    <?php if($item->category->start_percentage != null): ?>
                                        <span class="badge badge-info">(<?php echo e($item->category->start_percentage); ?>% - <?php echo e($item->category->end_percentage); ?>%)</span></p>
                                <?php endif; ?>
                                <p> Sub Category : <span class="text-bold"><?php echo e($item->childcategory->name); ?></span>
                                    <?php if(vendorActive()): ?>
                                    <span class="badge badge-info"><?php echo e($item->childcategory->commission ? $item->childcategory->commission->amount." %": translate("Commission is not selected")); ?></span>
                                    <?php endif; ?>
                                </p>
                            </td>

                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info dropdown-toggle btn-sm"
                                            data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a  href="<?php echo e(route('admin.products.edit', [$item->id,$item->slug])); ?>" class="nav-link text-black">Edit</a>
                                        </li>
                                        <li>
                                            <a  href="<?php echo e(route('admin.products.active', [$item->id,$item->slug])); ?>" class="nav-link text-black">Active</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#!" class="nav-link text-black"
                                               onclick="confirm_modal('<?php echo e(route('admin.products.destroy', $item->id)); ?>')">Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6"><h3 class="text-center" >No Data Found</h3></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                    <div class="float-left">
                        <?php echo e($requestProducts->links()); ?>

                    </div>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\work\Installed\xampp\htdocs\codecanyon-mn\resources\views/backend/products/product/index.blade.php ENDPATH**/ ?>