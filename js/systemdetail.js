const customModelRender = (row, istatus) => {
  if (istatus == "T" || istatus == "S") {
    return `<div class="button-container">`
      + `<button type="button" class="btn btn-primary btn-sm view" id="view_table_modal_${row['ID']}"><i class="far fa-eye"></i></button>`
      + `<button type="button" class="btn btn-danger btn-sm edit" id="edit_table_modal_${row['ID']}"><i class="far fa-edit"></i></button>` + `</div>`;
  } else {
    return `<div class="button-container">` + `<button type="button" class="btn btn-primary btn-sm view" id="view_table_modal_${row['ID']}"><i class="far fa-eye"></i></button>` + `</div>`;
  }
};

const customModelDelete = (row, istatus) => {
  if (istatus == "T" || istatus == "S") {
    return `<div class="button-container">`
      + `<button type="submit" name="btndelete" class="btn btn-danger btn-sm trash" id="trash_table_modal_${row['ID']}"><i class="fa fa-trash"></i></button>` + `</div>`;
  } else {
    return `<div class="button-container">`
      + `<button type="submit" name="btndelete" class="btn btn-danger btn-sm trash""><i class="fa fa-trash"></i></button>` + `</div>`;
  }
};


const ModelDetailRecno = (row, istatus) => {
  return`<button type="button" class="btn btn-primary btn-sm view " id="detail_view_${row}"><i class="far fa-eye"></i></button>`;
};

const ModelEditRecno = (row, istatus) => {
  return`<button type="button" class="btn btn-danger btn-sm edit " id="detail_edit_${row}"><i class="far fa-edit"></i></button>`;
};