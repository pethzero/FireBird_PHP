// แปลงฟังก์ชัน getStatusText เป็น Arrow Function

const getStatusText = (data) => {
  let statusText = '';
  if (data === '-1'){
    statusText = 'Active';
  } else if (data === 'C') {
    statusText = 'Cancel';
  } else if (data === 'D') {
    statusText = 'Done';
  }
  return statusText;
};

const getStatusTextOther = (data, column) => {
  // เช็คคอลัมน์ที่ต้องการแปลงค่า
  if (column === 'TABLEACTIVITYHD_STATUS')
  {
    // ทำการแปลงค่าตามต้องการ
    if (data == 'A'){
      return '<h5><span class="badge bg-secondary mt-2">ยังไม่เริ่มดำเนินการ</span></h5>'
    } else if (data == 'I') {
      return '<h5><span class="badge bg-info mt-2 text-dark">อยู่ระหว่างดำเนินการ</span></h5>';
    }else if (data == 'W') {
      return '<h5><span class="badge bg-warning mt-2 text-dark">รอดำเนินการ</span></h5>';
    }else if (data == 'D') {
      return '<h5><span class="badge bg-danger mt-2">ถูกเลื่อนออกไป</span></h5>';
    }else if (data == 'F') {
      return '<h5><span class="badge bg-success mt-2">เสร็จสิ้น</span></h5>'
    }else {
      return '';
    }
  }
  else if(column === 'TABLEACTIVITYHD_PRIORITY'){
    if (data == 'H') {
      return 'สูง';
    }else if (data == 'N') {
      return 'ปกติ';
    }else if (data == 'L') {
      return 'ต่ำ';
    }else {
      return '';
    }
  }
  // ถ้าไม่ใช่คอลัมน์ 'STATUS' ให้คืนค่าเป็นตัวอักษรเดิม
  // return data;
};

// แปลงฟังก์ชัน formatDateTH เป็น Arrow Function
const formatDateTHddmmyyyy = (data) => {
  if (!data || data === '0000-00-00') {
    return '00/00/0000'; // ถ้าค่าว่างหรือไม่ถูกต้อง ส่งค่าว่างกลับไป
  }
  
  const dateObj = new Date(data);
  const day = dateObj.getDate();
  const month = dateObj.getMonth() + 1;
  const year = dateObj.getFullYear() + 543;
  // const formattedDate = `${(month < 10 ? '0' + month : month)}/${(day < 10 ? '0' + day : day)}/${year}`;

  // const formattedDate = `${(day < 10 ? '0' + day : day)}.${(month < 10 ? '0' + month : month)}.${year}`;
  const formattedDate = `${(day < 10 ? '0' + day : day)}/${(month < 10 ? '0' + month : month)}/${year}`;
  // const formattedDate = `${(day < 10 ? '0' + day : day)}-${(month < 10 ? '0' + month : month)}-${year}`; 
  return formattedDate;
};

// แปลงฟังก์ชัน formatDate เป็น Arrow Function
const formatDate = (data) => {
  if (!data || data === '0000-00-00') {
    return '00/00/0000'; // ถ้าค่าว่างหรือไม่ถูกต้อง ส่งค่าว่างกลับไป
  }
  
  const dateObj = new Date(data);
  const day = dateObj.getDate();
  const month = dateObj.getMonth() + 1;
  const year = dateObj.getFullYear();
  // const formattedDate = `${(day < 10 ? '0' + day : day)}.${(month < 10 ? '0' + month : month)}.${year}`;
  const formattedDate = `${(day < 10 ? '0' + day : day)}/${(month < 10 ? '0' + month : month)}/${year}`;
  return formattedDate;
};

const formatCurrency = (amount) => {
  if (amount === '') {
    return '';
  }
  let formattedAmount = parseFloat(amount).toFixed(2);
  formattedAmount = formattedAmount.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  formattedAmount += '฿';
  return formattedAmount;
};
const formatDecimalData  = (data) =>{
  let formattedDecimalData =parseFloat(data).toFixed(3);
  return formattedDecimalData;
};

const formatImageBlob  = (data) =>{
  if (data){return '<img src="data:image/jpeg;base64,' + data + '" width="50" height="50">';}
  else{return '<div style="width: 50px; height: 50px;"></div>';}
};

const customFocusRender = (data, type, row,datainput) => {
  if (datainput === 'focusdatahd') {
    return `<button class="btn btn-primary ${datainput}">PM TIME</button>`;
  } else {
    return `<button class="btn btn-primary ${datainput}">PM TIME</button>`;
  }
};

const customModelRender = (data, type, row,idmodel,istatus) => {
  if(istatus == "admin")
  {
    return `<button class="btn btn-primary btn-sm ${idmodel}" data-bs-toggle="modal" data-bs-target="#${idmodel}" data-bs-row-id="${row['RECNO']}"><i class="fa fa-eye"></i></button>`;
  }else
  {
    return `<button class="btn btn-primary btn-sm ${idmodel}" data-bs-toggle="modal" data-bs-target="#${idmodel}" data-bs-row-id="${row['RECNO']}"><i class="fa fa-eye"></i></button>`;
  }
};

const customButtonEdit = (data, type,row,idclass,idname) => {
  // return `<button class="btn btn-danger btn-sm ${idclass}" id="${row['RECNO']}">${idname}</button>`;
  return `<button class="btn btn-danger btn-sm ${idclass}" id="${row['RECNO']}"><i class="far fa-edit"></i></button>`;
  // return '';
};


var dtcolumn = 
{
  ///////////////////////////  DATAQUOD ///////////////////////////
  'dataquoud':   [
    { data: 'RECNO' },
    {
      data: null,
      render: function(data, type, row)
      {
        return customModelRender (data, type, row, 'myModal','SHOW' );
      }
    },
    { data: 'QDOCNO' },
    { data: 'STATUS',
      render: function(data, type, row) {
      // let text = row.EMPNAMEAPPROVER !== '' ? 'อนุมัติแล้ว' : 'รออนุมัติ';
      let text = row.EMPNAMEAPPROVER !== '' ? '<h5><span class="badge bg-success mt-2">อนุมัติแล้ว</span></h5>' : '<h5><span class="badge bg-danger mt-2">รออนุมัติ</span></h5>';
      return text;
    },
    },
    { data: 'CODE' },
    { data: 'NAME' },
    { data: 'QDOCDATE',render: formatDate},
    { data: 'DELYDATE',render: formatDate},
    { data: 'NETAMT' ,render: formatCurrency},
    // { data: 'NETAMT' },
    { data: 'EMPNAMESALES' },
    { data: 'EMPNAMEMAKER' },
    { data: 'EMPNAMEAPPROVER' },
    { data: 'REMARK' },
  ],
  'dataquoud_dt':
  [
  {data: 'QUOTHD'},
  {data: 'CODE'},
  {data: 'DETAIL'},
  {data: 'QUAN'},
  {data: 'UNITNAME'},
  {data: 'UNITAMT',render: formatCurrency},
  ],
  //////////////////////////////////////////////////////////////////////////////////////////////
  'datainvent': [
    { data: 'RECNO' },
    { data: 'CODE' },
    { data: 'TYPENAME' },
    { data: 'PRODNAME'},
    { data: 'QUAN',   render: formatDecimalData},
    { data: 'COSTAMT',render: formatCurrency},
    { data: 'SALEAMT',render: formatCurrency},
    { data: 'LASTIN' ,render: formatDate},
    { data: 'LASTOUT',render: formatDate}
  ]
  ,
  /////////////////////////////////////////////////////////////////////////////////////////////
  'datapurc':   [
    { data: 'RECNO' },
    {
      data: null,
      render: function(data, type, row)
      {
        return customModelRender (data, type, row, 'myModal','SHOW' );
      }
    },
    { data: 'DOCNO' },
    { data: 'STATUS',
    render: function(data, type, row) {
      let text = row.EMPNAMEAPPROVER !== '' ? 'อนุมัติแล้ว' : 'รออนุมัติ';
      return text;
    },
    },
    { data: 'CODE' },
    { data: 'NAME' },
    { data: 'DOCDATE',render: formatDate},
    { data: 'DELYDATE',render: formatDate},
    { data: 'NETAMT' ,render: formatCurrency},
    // { data: 'NETAMT'},
    { data: 'EMPNAMEBUYER' },
    { data: 'EMPNAMEMAKER' },
    { data: 'EMPNAMEAPPROVER' },
    { data: 'REMARK' },
  ],
  'datapurc_dt':
  [
  {data: 'PURCHD'},
  {data: 'CODE'},
  {data: 'DETAIL'},
  {data: 'QUANORD'},
  {data: 'UNITNAME'},
  {data: 'UNITAMT',render: formatCurrency},
  ],
    ///////////////////////////////
  'datamachine': [
    { data: 'RECNO' },
    {
      data: null,
      render: function(data, type, row) {
        return customFocusRender(data, type, row, 'focusdatahd');
      }
    },
    { data: 'IMAGE',render: formatImageBlob},
    { data: 'STATUS'},
    { data: 'MCCODE'},
    { data: 'MCNAME' },
    { data: 'MCTYPE'}
    // { data: 'CAPWEEK' },
    // { data: 'MCCOSTRATE'  },
    // { data: 'COSTFACTOR' },
    // { data: 'DAYJOB' },
    // { data: 'NIGHTJOB' }
  ],
  'datamachinepmtime': [
   { data: 'RECNO'},
   {
    data: null,
    render: function(data, type, row) {
      return customModelRender(data, type, row, 'pmtime','show');
    }
   },
   { data: 'Machine'},
   { data: 'Name'},
   { data: 'No'},
   { data: 'Interval'},
   { data: 'Document'},
   { data: 'Job'},
   { data: 'Area'},
   { data: 'Delay'},
   { data: 'Remark'}
  ],
  ///////////////////////////////////////////////////////////////////////////////////////////

  //////////////////////////////////////////////  ACTIVITYHD //////////////////////////////////////////////
  'DATA_ACTIVITYHD': [
    { data: 'RECNO' },
    // {data: null,render: function(data, type, row){return "";}},
    {
      data: null,
      render: function(data, type, row)
      {
        return customButtonEdit (data, type, row, 'edit','แก้ไข' );
      }
    },
    {data: 'DOCNO'},
    // {data: 'STATUS'},
    {data: null,render: function(data)
      {
      return getStatusTextOther(data.STATUS,'TABLEACTIVITYHD_STATUS')
      ;}
    },
    {data: 'CUSTNAME'},
    {data: 'CONTNAME'},
    // {data: 'STARTD',render: formatDate},
    {data: 'STARTD',render: formatDate},
    // {data: 'STARTD',render: formatDate,"sType": "date-uk"},
    
    // {data: 'PRIORITY'},
    {data: null,render: function(data)
      {
      return getStatusTextOther(data.PRIORITY,'TABLEACTIVITYHD_PRIORITY')
      ;}
    },
    {data: 'PRICECOST',render: formatCurrency},
    {data: 'PRICEPWITHDRAW',render: formatCurrency},
    {data: 'OWNERNAME'},
   ],

   'DATA_EQUIPMENT': [
    { data: 'RECNO' },
    {  data: null,
      render: function(data, type, row)
      {
        return customButtonEdit (data, type, row, 'edit','แก้ไข' );
      }
    },
    {data: 'DOCNO'},
   ],
   'DATA_NOTIMAINTEN': [
    { data: 'RECNO' },
    {  data: null,
      render: function(data, type, row)
      {
        return customButtonEdit (data, type, row, 'edit','แก้ไข' );
      }
    },
    {data: 'DOCNO'},
    {data: 'NAME'},
    {data: 'EQUIPMENT_NAME'},
    {data: 'CONTNAME'},
    {data: 'STATUS'},
    {data: 'PRIORITY'},
    {data: 'WARNINGDATE'},
   ]
};