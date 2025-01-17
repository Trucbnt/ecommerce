const PUBLISH = [
  {
    value: 0,
    label: 'Chọn tình trạng'
  },
  {
    value: 1,
    label: 'Đã xuất bản'
  },
  {
    value: 2,
    label: 'Chưa xuất bản'
  }
];

const PAGESIZE = ['10', '20', '30', '50', '100'];

const PRODUCT_TYPE = [
  {
    value: 'simple',
    label: 'Sản phẩm đơn giản'
  },
  {
    value: 'variable',
    label: 'Sản phẩm có biến thể'
  }
];

const TAXT_STATUS = [
  {
    value: 1,
    label: 'Giá sản phẩm đã bao gồm thuế'
  },
  {
    value: 2,
    label: 'Giá sản phẩm chưa bao gồm thuế'
  }
];

const WAREHOUSE_CONFIG = [
  {
    value: '5-10-3-5',
    label: 'Nhỏ (5 dãy, 10 kệ, 3 tầng, 5 khoang)'
  },
  {
    value: '10-20-4-8',
    label: 'Trung bình (10 dãy, 20 kệ, 4 tầng, 8 khoang)'
  },
  {
    value: '20-30-5-10',
    label: 'Lớn (20 dãy, 30 kệ, 5 tầng, 10 khoang)'
  }
];
export { PUBLISH, PAGESIZE, PRODUCT_TYPE, TAXT_STATUS, WAREHOUSE_CONFIG };
