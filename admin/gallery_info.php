<div class="card-body">

            <h5 class="card-title text-capitalize"><a href="" title=""><?= empty($galleries->title) ? 'No Title' : $galleries->title; ?></a></h5>

            <p class="card-text">
              <a href="" title=""><?= empty($galleries->description) ? 'No Description' : trim_body($galleries->description, 100); ?></a>
            </p>

            <a href="photos_edit.php?id=<?= $galleries->id; ?>" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit This Picture"><i class="mdi mdi-pencil"></i></a>

            <a href="photo_delete.php?id=<?= $galleries->id; ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete This Picture"><i class="mdi mdi-delete"></i></a>
          </div><!-- end of card body -->