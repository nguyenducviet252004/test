import { useSelector } from "react-redux";
import { RootState, useAppDispatch } from "../../Redux/store";
import { useEffect, useState } from "react";
import { fetchCart } from "../../Redux/Reducer/CartReducer";
import { Link, useNavigate } from "react-router-dom";
import { fetchVouchers } from "../../Redux/Reducer/VoucherReducer";
import { DeleteOutlined, EditOutlined } from "@ant-design/icons";
import api from "../../Axios/Axios";
import { ExclamationCircleFilled, EditFilled } from "@ant-design/icons";
import { Button, Modal, Space } from "antd";
import { message } from "antd";
import "./cart.css";
const { confirm } = Modal;
interface CartProps {
  userId: number;
}

const CartComponent: React.FC<CartProps> = ({ userId }) => {
  const navigate = useNavigate();
  const dispatch = useAppDispatch();
  const cart = useSelector((state: RootState) => state.cart.items);
  const vouchers = useSelector((state: RootState) => state.voucherReducer);
  const [loading, setLoading] = useState(true);
  const [voucherCode, setVoucherCode] = useState<string>("");
  const [voucherValid, setVoucherValid] = useState<boolean | null>(null);
  const [discountValue, setDiscountValue] = useState<number>(0);
  const [isCart, setIsCart] = useState<any[]>([]);
  const [numberCart0, setNumberCart0] = useState<any[]>([]);
  const [cartEmpty, setCartEmpty] = useState<boolean>(false);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [productid, setProductId] = useState<any>();
  const [selectedColor, setSelectedColor] = useState<any>(null);
  const [selectedSize, setSelectedSize] = useState<any>(null);
  const [isIdQuantity, setIdQuantity] = useState<any>();
  const [selectedVariantId, setSelectedVariantId] = useState<any>(null);
  const [selectedItems, setSelectedItems] = useState<number[]>([]);

  useEffect(() => {
    dispatch(fetchCart(userId));
  }, [dispatch, userId]);

  useEffect(() => {
    dispatch(fetchVouchers());
  }, [dispatch]);

  useEffect(() => {
    if (productid && selectedSize && selectedColor) {
      const variant = productid.variants?.find(
        (v: any) =>
          v.size_id === selectedSize &&
          v.color_id === selectedColor
      );
      setSelectedVariantId(variant ? variant.id : null);
    } else {
      setSelectedVariantId(null);
    }
  }, [productid, selectedSize, selectedColor]);

  const handleVoucherInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setVoucherCode(e.target.value);
  };

  const showDeleteConfirm = (id: any) => {
    confirm({
      title: "Bạn muốn xóa sản phẩm này khỏi giỏ hàng?",
      icon: <ExclamationCircleFilled />,
      okText: "Xóa",
      okType: "danger",
      cancelText: "Hủy",
      onOk() {
        handleDelete(id);
      },
      onCancel() {
        console.log("Cancel");
      },
    });
  };

  const showModal = (productId: any, cartItemId: any) => {
    setIsModalOpen(true);
    setIdQuantity(cartItemId);
    getVariant(productId);
  };

  console.log("Biến thể", productid);

  const handleOk = () => {
    setIsModalOpen(false);
    if (selectedVariantId) {
      updateVariant(isIdQuantity, selectedVariantId);
    } else {
      message.error("Vui lòng chọn đúng biến thể!");
    }
  };

  const handleCancel = () => {
    setIsModalOpen(false);
  };

  const getAllCart = async () => {
    try {
      const token = localStorage.getItem("token");
      const user = localStorage.getItem("user");
      if (user && token) {
        let parsedUser;
        try {
          parsedUser = JSON.parse(user);
        } catch (error) {
          console.log("Dữ liệu người dùng không hợp lệ");
          return;
        }
        const userId = parsedUser.user.id;
        const { data } = await api.get(`/carts/${userId}`);
        setIsCart(data.cart_items);
      }
    } catch (error) {
      console.log(error);
    } finally {
      setLoading(false);
    }
  };

  console.log("Cảtttttt", isCart);
  const updateCartQuantity = async (id: any, quantity: number) => {
    try {
      await api.put(`/carts/${id}`, { quantity });
      getAllCart();
    } catch (error) {
      message.error('Vượt quá số lượng có trong kho !')
    }
  };

  const updateVariant = async (cartItemId: any, product_variant_id: any) => {
    try {
      await api.put(`/carts/${cartItemId}`, { product_variant_id });
      getAllCart();
      message.success("Cập nhật giỏ hàng thành công !");
    } catch (error) {
      console.log(error);
    }
  };

  const handleColorSelect = (colorId: any) => {
    setSelectedColor(colorId);
  };

  const handleSizeSelect = (sizeId: any) => {
    setSelectedSize(sizeId);
  };

  const handleItemSelection = (itemId: number) => {
    setSelectedItems((prevSelectedItems) => {
      if (prevSelectedItems.includes(itemId)) {
        return prevSelectedItems.filter((id) => id !== itemId);
      } else {
        return [...prevSelectedItems, itemId];
      }
    });
  };

  const handleSelectAll = () => {
    if (selectedItems.length === isCart.length) {
      setSelectedItems([]);
    } else {
      setSelectedItems(isCart.map((item) => item.id));
    }
  };

  const handleCheckout = () => {
    if (selectedItems.length > 0) {
      localStorage.setItem("selectedCartItems", JSON.stringify(selectedItems));
      navigate(`/checkout/${userId}`);
    } else {
      message.warning("Vui lòng chọn sản phẩm để thanh toán.");
    }
  };

  const handleColorIdcart = (idCartss: any) => {
    setIdQuantity(idCartss);
  };

  const handleDelete = async (cartItemId: number) => {
    try {
      await api.delete(`/carts/${cartItemId}`);
      window.location.reload();
    } catch (error) {
      console.log(error);
    }
  };

  const getVariant = async (idProduct: number) => {
    try {
      const res = await api.get(`/products/${idProduct}`);
      setProductId(res.data);
    } catch (error) {
      console.log(error);
    }
  };

  useEffect(() => {
    getAllCart();
  }, []);

  if (loading)
    return (
      <div>
        <div id="preloader-active">
          <div className="preloader d-flex align-items-center justify-content-center">
            <div className="preloader-inner position-relative">
              <div className="page-loading text-center">
                <div className="page-loading-inner">
                  <div />
                  <div />
                  <div />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    );

  const selectedCartItems = isCart.filter((item) =>
    selectedItems.includes(item.id)
  );

  return (
    <main className="main">
      <section className="section block-blog-single block-cart">
        <div className="container">
          <div className="top-head-blog">
            <div className="text-center">
              <h2 className="font-4xl-bold">Giỏ hàng</h2>
              <div className="breadcrumbs d-inline-block">
                <ul>
                  <li>
                    <a href="#">Trang chủ</a>
                  </li>
                  <li>
                    <a href="#">Cửa hàng</a>
                  </li>
                  <li>
                    <a href="#">Giỏ hàng</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div className="box-table-cart">
            <div className="table-responsive">
              <table className="table table-striped table-cart">
                <thead>
                  <tr>
                    <th>
                      <input
                        type="checkbox"
                        onChange={handleSelectAll}
                        checked={
                          isCart.length > 0 &&
                          selectedItems.length === isCart.length
                        }
                      />
                    </th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tạm tính</th>
                    <th>Hành động</th>
                  </tr>
                </thead>
                {isCart.length === 0 ? (
                  <p
                    style={{
                      fontFamily: "Raleway",
                      fontStyle: "italic",
                      color: "red",
                      marginTop: "40px",
                      fontSize: "16px",
                      fontWeight: "normal",
                    }}
                  >
                    *Giỏ của bạn đang trống
                  </p>
                ) : (
                  isCart.map((item, index) => (
                    <tbody key={index}>
                      <tr>
                        <td>
                          <input
                            type="checkbox"
                            checked={selectedItems.includes(item.id)}
                            onChange={() => handleItemSelection(item.id)}
                          />
                        </td>
                        <td>
                          <p>{item.product_name}</p>
                          <div
                            style={{
                              display: "flex",
                              gap: "3px",
                              justifyContent: "center",
                            }}
                          >
                            <span
                              style={{
                                fontFamily: "Raleway",
                                fontSize: "18px",
                              }}
                            ></span>
                            <p style={{ fontSize: "12px", color: "gray" }}>
                              {item.color}
                            </p>
                            <span style={{ color: "gray" }}>,</span>
                            <p style={{ fontSize: "12px", color: "gray" }}>
                              {item.size}
                            </p>
                          </div>
                        </td>
                        <td>
                          <img
                            src={`http://127.0.0.1:8000/storage/${item.avatar}`}
                            width={"50px"}
                            alt={item.product_name}
                          />
                        </td>
                        <td>
                          <span
                            className="brand-1"
                            style={{ fontFamily: "Raleway" }}
                          >
                            {Number(item.price)
                              ? Number(item.price).toLocaleString("vi-VN", {
                                  style: "currency",
                                  currency: "VND",
                                })
                              : "Không có giá"}
                          </span>
                        </td>
                        <td>
                          <div className="product-quantity">
                            <div className="quantity">
                              {/* Giảm số lượng */}
                              <span
                                className="icon icon-minus d-flex align-items-center"
                                onClick={() =>
                                  item.quantity > 1 &&
                                  updateCartQuantity(item.id, item.quantity - 1)
                                }
                              >
                                <svg
                                  width={24}
                                  height={24}
                                  viewBox="0 0 24 24"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg"
                                >
                                  <path
                                    d="M17.75 11.25C17.9167 11.25 18 11.3333 18 11.5V12.5C18 12.6667 17.9167 12.75 17.75 12.75H6.25C6.08333 12.75 6 12.6667 6 12.5V11.5C6 11.3333 6.08333 11.25 6.25 11.25H17.75Z"
                                    fill="currentColor"
                                  />
                                </svg>
                              </span>
                              <input
                                className="input-quantity border-0 text-center"
                                type="number"
                                value={item.quantity}
                                readOnly
                              />
                              {/* Tăng số lượng */}
                              <span
                                className="icon icon-plus d-flex align-items-center"
                                onClick={() =>
                                  updateCartQuantity(item.id, item.quantity + 1)
                                }
                              >
                                <svg
                                  width={24}
                                  height={24}
                                  viewBox="0 0 24 24"
                                  fill="none"
                                  xmlns="http://www.w3.org/2000/svg"
                                >
                                  <path
                                    d="M17.75 11.25C17.9167 11.25 18 11.3333 18 11.5V12.5C18 12.6667 17.9167 12.75 17.75 12.75H12.75V17.75C12.75 17.9167 12.6667 18 12.5 18H11.5C11.3333 18 11.25 17.9167 11.25 17.75V12.75H6.25C6.08333 12.75 6 12.6667 6 12.5V11.5C6 11.3333 6.08333 11.25 6.25 11.25H11.25V6.25C11.25 6.08333 11.3333 6 11.5 6H12.5C12.6667 6 12.75 6.08333 12.75 6.25V11.25H17.75Z"
                                    fill="currentColor"
                                  />
                                </svg>
                              </span>
                            </div>
                          </div>
                        </td>
                        <td>
                          <span
                            className="brand-1"
                            style={{ fontFamily: "Raleway" }}
                          >
                            {(
                              Number(item?.price || 0) *
                              Number(item?.quantity || 1)
                            ).toLocaleString("vi-VN", {
                              style: "currency",
                              currency: "VND",
                            })}
                          </span>
                        </td>
                        <td>
                          <DeleteOutlined
                            onClick={() => showDeleteConfirm(item.id)}
                          />
                          <EditOutlined
                            onClick={() => showModal(item.product_id, item.id)}
                            style={{ paddingLeft: "10px" }}
                          />
                        </td>
                      </tr>
                    </tbody>
                  ))
                )}
              </table>
            </div>
            <Modal
              title={productid?.name}
              open={isModalOpen}
              onOk={handleOk}
              onCancel={handleCancel}
              cancelText="Hủy"
              okText="Lưu"
            >
              {/* color */}
              <label
                style={{
                  fontFamily: "Raleway",
                  fontSize: "16px",
                  paddingTop: "15px",
                  paddingBottom: "5px",
                }}
              >
                Color: Chọn màu
              </label>
              <main className="variant-update">
                {productid?.colors.map((cl: any) => (
                  <div>
                    <div>
                      <button
                        style={{
                          color: selectedColor === cl?.id ? "white" : "black",
                          backgroundColor:
                            selectedColor === cl?.id
                              ? "rgb(159,134,217)"
                              : "white",
                        }}
                        onClick={() => handleColorSelect(cl?.id)}
                        className="variants-update"
                      >
                        {cl?.name_color}
                      </button>
                    </div>
                  </div>
                ))}
              </main>

              {/* size */}
              <label
                style={{
                  fontFamily: "Raleway",
                  fontSize: "16px",
                  paddingTop: "15px",
                  paddingBottom: "5px",
                }}
              >
                Size: Chọn size
              </label>
              <main className="variant-update">
                {productid?.sizes.map((sz: any) => (
                  <div>
                    <button
                      style={{
                        color: selectedSize === sz?.id ? "white" : "black",
                        backgroundColor:
                          selectedSize === sz?.id
                            ? "rgb(159,134,217)"
                            : "white",
                      }}
                      onClick={() => handleSizeSelect(sz?.id)}
                      className="variants-update"
                    >
                      {sz?.size}
                    </button>
                  </div>
                ))}
              </main>
            </Modal>

            {isCart.length > 0 && (
              <div
                className="row"
                style={{
                  display: "flex",
                  justifyContent: "space-between",
                  alignItems: "center",
                  background: "#fff",
                  padding: "15px",
                  borderTop: "1px solid #eee",
                  marginTop: "30px",
                }}
              >
                <div style={{ flex: "0 0 auto" }}>
                  <label
                    style={{
                      display: "flex",
                      alignItems: "center",
                      gap: "10px",
                      cursor: "pointer",
                    }}
                  >
                    <input
                      type="checkbox"
                      onChange={handleSelectAll}
                      checked={
                        isCart.length > 0 &&
                        selectedItems.length === isCart.length
                      }
                    />
                    <span>Tất cả ({isCart.length} sản phẩm)</span>
                  </label>
                </div>
                <div
                  style={{
                    display: "flex",
                    justifyContent: "flex-end",
                    alignItems: "center",
                    gap: "20px",
                  }}
                >
                  <span>
                    Tổng thanh toán ({selectedItems.length} sản phẩm):
                    <span
                      style={{
                        color: "#B61C1C",
                        fontWeight: "bold",
                        marginLeft: "5px",
                        fontSize: "1.2rem",
                      }}
                    >
                      {(
                        selectedCartItems.reduce(
                          (acc, item) =>
                            acc +
                            Number(item.price) * Number(item.quantity),
                          0
                        ) *
                        (1 - discountValue / 100)
                      ).toLocaleString("vi-VN", {
                        style: "currency",
                        currency: "VND",
                      })}
                    </span>
                  </span>
                  <button
                    className="btn btn-brand-1-xl-bold font-sm-bold"
                    onClick={handleCheckout}
                    disabled={selectedItems.length === 0}
                    style={{
                      minWidth: "150px",
                      backgroundColor:
                        selectedItems.length > 0 ? "#B61C1C" : "#ccc",
                      border: "none",
                    }}
                  >
                    Mua hàng ({selectedItems.length})
                  </button>
                </div>
              </div>
            )}
          </div>
        </div>
      </section>
    </main>
  );
};

export default CartComponent;
