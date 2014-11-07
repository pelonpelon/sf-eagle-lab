<div class="wrap">
    <h2 class="nav-tab-wrapper">
        <a class="nav-tab <?php echo $type=='posts'?'nav-tab-active':'';?>" href="<?php echo $postUrl;?>">Posts</a>
        <a class="nav-tab <?php echo $type=='pages'?'nav-tab-active':'';?>" href="<?php echo $pageUrl;?>">Pages</a>
    </h2>

    <div class="tablenav top">

    </div>
    <table class="wp-list-table widefat fixed" cellspacing="0">
        <thead>
            <tr>
                <th id="title" class="manage-column column-title sortable desc" style="width:90%" scope="col">
                    <a href="<?php echo $postUrl;?>">
                        <span>Title</span>
                    </a>
                </th>
                <th>
                    <a href="#">
                        <span>Action</span>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($columns as $c){?>
            <tr>
                <td><a href="#" class="row-title"><?php echo $c;?></a></td>
                <td>
                    <a href="#">
                        Hide it
                    </a>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>