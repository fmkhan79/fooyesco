<div class="content-header">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h4 class="mt-1 text-dark"><?php echo ucwords($page_title); ?></h4>
                    </div>
                    <div class="col-6">
                     
                    </div>
                </div>
            </div>

            <table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Name</th>
            <th>Role ID</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user->name; ?></td>
<td><?php echo ($user->role_id == 1) ? "Super Admin" : "Restaurant Owner"; ?></td>
            </tr> 
        <?php endforeach; ?>
    </tbody>
</table>
        </div>
    </div><!-- /.container-fluid -->
</div>
