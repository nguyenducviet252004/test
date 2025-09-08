import React, { useEffect, useState } from "react";
import { Navigate, useNavigate, useParams } from "react-router-dom";
import Star from "../../assets/imgs/template/icons/star.svg";
import { useAppDispatch } from "../../Redux/store";
import axios from "axios";
import { notification } from "antd";
import { addToCart } from "../../Redux/Reducer/CartReducer";
import { IProduct } from "../../types/cart";
import { message } from "antd";
import { Rate } from "antd";
import api from "../../Axios/Axios";
import { Link } from "react-router-dom";

import {
  MinusOutlined,
  PlusOutlined,
  ShoppingOutlined,
} from "@ant-design/icons";
import "./ProductDetail.css";
const ProductDetailComponent: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const dispatch = useAppDispatch();
  const [product, setProduct] = useState<any>(null);
  const [loading, setLoading] = useState(true);
  const [productById, setProductById] = useState<IProduct[]>([]);
  const [error, setError] = useState("");
  const [selectedSize, setSelectedSize] = useState("");
  const [selectedColor, setSelectedColor] = useState<string | null>(null);
  const [quantity, setQuantity] = useState<number>(1);
  const [isCate, setIsCate] = useState<number>(0);
  const [selectedIndex, setSelectedIndex] = useState(0);
  const [isLogin, setIsLogin] = useState<boolean>(false);
  const [checkAdmin, setCheckAdmin] = useState<boolean>(false);
  const navigate = useNavigate();
  const [selectedVariant, setSelectedVariant] = useState<any>(null);

  const convertToVND = (usdPrice: number) => {
    return usdPrice.toLocaleString("vi-VN");
  };

  const handleIncrease = () => {
    setQuantity((prevQuantity) => prevQuantity + 1);
  };

  const user = JSON.parse(localStorage.getItem("user") || "{}");
  console.log("siu", user);

  const handleDecrease = () => {
    setQuantity((prevQuantity) => (prevQuantity > 1 ? prevQuantity - 1 : 1));
  };

  const handleThumbnailClick = (index: number) => {
    setSelectedIndex(index);
  };

  useEffect(() => {
    const fetchProductDetail = async () => {
      try {
        const response = await axios.get(
          `http://localhost:8000/api/products/${id}`
        );
        setProduct(response.data);
      } catch (error) {
        setError("Failed to fetch product details");
      } finally {
        setLoading(false);
      }
    };

    const userz = localStorage.getItem("user");
    const checkadmin = JSON.parse(userz!);

    console.log(checkadmin, "alllll");

    if (userz) {
      try {
        const checkadmin = JSON.parse(userz);
        console.log(checkadmin, "alllll");
        setIsLogin(true); 
        if (checkadmin?.user?.role === 2) {
          setCheckAdmin(true); 
        } else {
          setCheckAdmin(false); 
        }
      } catch (error) {
        console.error("Dữ liệu trong localStorage không hợp lệ", error);
      }
    } else {
      console.warn("Không tìm thấy user trong localStorage");
    }
    fetchProductDetail();
  }, [id]);

  useEffect(() => {
    const GetProductsById = async () => {
      try {
        if (product?.categories?.id) {
          const { data } = await api.get(
            `/categories/${product.categories.id}/products`
          );
          console.log("sản phẩm thoe id", data);
          setProductById(data.products);
        }
      } catch (error) {
        console.log(error);
      }
    };

    GetProductsById();
  }, [product]);

  // Khi chọn size hoặc màu, tìm variant phù hợp
  useEffect(() => {
    if (product && selectedSize && selectedColor) {
      const variant = product.variants?.find(
        (v: any) =>
          v.size_id === selectedSize && v.color_id === selectedColor
      );
      setSelectedVariant(variant || null);
    } else {
      setSelectedVariant(null);
    }
  }, [product, selectedSize, selectedColor]);

  // Hàm kiểm tra xem một biến thể có còn hàng không
  const isVariantAvailable = (colorId: string, sizeId: string) => {
    if (!product) return false;
    const variant = product.variants?.find(
      (v: any) => v.color_id === colorId && v.size_id === sizeId
    );
    return variant && variant.quantity > 0;
  };

  console.log("chi tiết sản phẩm", productById);

  const handleAddToCart = async () => {
    if (!isLogin) {
      notification.warning({
        message: "Vui lòng đăng nhập để mua hàng !",
        className: "warning-message",
        placement: "bottomRight",
      });
      return;
    }
    if (checkAdmin) {
      notification.warning({
        message: "Admin không được phép mua hàng !",
        className: "warning-message",
        placement: "bottomRight",
      });
      return;
    }
    if (!selectedVariant) {
      notification.warning({
        message: "Vui lòng chọn đúng kích thước và màu sắc có hàng!",
      });
      return;
    }
    if (quantity > selectedVariant.quantity) {
      message.error(`Số lượng sản phẩm này chỉ còn ${selectedVariant.quantity} trong kho !`);
      return;
    }
    try {
      const cartData = {
        product_variant_id: selectedVariant.id,
        quantity,
      };
      await dispatch(addToCart(cartData));
      notification.success({
        message: "Thêm vào giỏ hàng thành công !",
        placement: "bottomRight",
      });
    } catch (error) {
      console.error("Lỗi khi thêm sản phẩm vào giỏ hàng:", error);
      notification.error({
        message: "Không thể thêm sản phẩm vào giỏ hàng. Vui lòng thử lại!",
      });
    }
  };

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
  if (error) return <div>{error}</div>;
  if (!product) return <div>Product not found.</div>;

  return (
    <>
      <main className="main">
        <div className="section block-shop-head-2 block-breadcrumb-type-1">
          <div className="container">
            <div className="breadcrumbs">
              <ul>
                <li>
                  <a href="#">Trang chủ</a>
                </li>
                <li>
                  <a href="#">Cửa hàng</a>
                </li>
                <li>
                  <a href="#">{product.name}</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <section className="section block-product-content">
          <div className="container">
            <div className="row">
              <div className="col-lg-5 box-images-product-left">
                <div className="detail-gallery">
                  <div className="slider-nav-thumbnails">
                    {product.galleries && product.galleries.length > 0 ? (
                      product.galleries.map((gallery: any, index: any) => (
                        <div
                          key={gallery.id}
                          onClick={() => handleThumbnailClick(index)}
                        >
                          <div className="item-thumb">
                            <img
                              src={`${gallery.image_path}`}
                              alt="Thumbnail"
                            />
                          </div>
                        </div>
                      ))
                    ) : (
                      <p>Không có ảnh trong thư viện.</p>
                    )}
                  </div>
                  <div className="box-main-gallery">
                    <a className="zoom-image glightbox" />
                    <div className="product-image-slider">
                      <figure className="border-radius-10">
                        <a className="glightbox">
                          <img width={"100%"} src={product.avatar_url} />
                        </a>
                      </figure>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-lg-5 box-images-product-middle">
                <div className="box-product-info">
                  {/* <label className="flash-sale-red">Extra 2% off</label> */}
                  <h2
                    style={{ fontFamily: "Raleway", marginBottom: "10px" }}
                    className="font-2xl"
                  >
                    {product.name}
                  </h2>
                  {/* Đánh giá trung bình */}
                  {product.reviews.length > 0 && (
                    <div className="block-rating">
                      <Rate
                        style={{ fontSize: "14px" }}
                        disabled
                        defaultValue={product.average_rating}
                      />
                    </div>
                  )}
                  {/* end */}
                  {/* <span
                    style={{ fontFamily: "Raleway" }}
                    className="font-md neutral-500"
                  >
                    ({product.reviews.length} Reviews - {product.sell_quantity}{" "}
                    Orders)
                  </span> */}
                  <div className="block-price" style={{ marginTop: "20px" }}>
                    <span style={{ fontFamily: "Raleway", fontSize: "25px" }} className="price-main">
                      {selectedVariant
                        ? `${convertToVND(selectedVariant.price_sale || selectedVariant.price)}đ`
                        : "Chọn biến thể để xem giá"}
                    </span>
                  </div>
                  

                  <div className="block-color">
                    <span style={{ fontFamily: "Raleway" }}>Color:</span>
                    <label style={{ fontFamily: "Raleway", marginLeft:'5px' }}>
                      {product.colors.find((c: any) => c.id === selectedColor)?.name_color || "Chọn Màu"}
                    </label>
                    <ul className="list-color-detail">
                      {product.colors.map((color: any) => {
                        const isAvailable = product.sizes.some((size: any) => isVariantAvailable(color.id, size.id));
                        return (
                          <button
                            className={`button-color ${
                              !isAvailable ? "disabled" : ""
                            }`}
                            key={color.id}
                            style={{
                              fontFamily: "Raleway",
                              padding: "10px 15px",
                              border:
                                selectedColor === color.id
                                  ? "1px solid rgb(159,137,219)"
                                  : "1px solid gray",
                              borderRadius: "8px",
                              backgroundColor: !isAvailable
                                ? "#f0f0f0"
                                : "white",
                              margin: "0 5px 0 0",
                              color:
                                selectedColor === color.id
                                  ? "rgb(159,137,219)"
                                  : !isAvailable
                                  ? "#ccc"
                                  : "black",
                              cursor: !isAvailable ? "not-allowed" : "pointer",
                            }}
                            onClick={() => isAvailable && setSelectedColor(color.id)}
                            disabled={!isAvailable}
                          >
                            {color.name_color}
                          </button>
                        );
                      })}
                    </ul>
                  </div>
                  <div className="block-size">
                    <span style={{ fontFamily: "Raleway" }}>Size:</span>
                    <label style={{ fontFamily: "Raleway", marginLeft:'5px' }}>
                      {product.sizes.find((s: any) => s.id === selectedSize)?.size || "Chọn Size"}
                    </label>
                    <div className="list-sizes-detail">
                      {product.sizes.map((size: any) => {
                        const isAvailable = selectedColor
                          ? isVariantAvailable(selectedColor, size.id)
                          : product.colors.some((color: any) =>
                              isVariantAvailable(color.id, size.id)
                            );
                        return (
                          <button
                            className={`button-size ${
                              !isAvailable ? "disabled" : ""
                            }`}
                            key={size.id}
                            style={{
                              padding: "10px 15px",
                              border:
                                selectedSize === size.id
                                  ? "1px solid rgb(159,137,219)"
                                  : "1px solid gray",
                              borderRadius: "8px",
                              backgroundColor: !isAvailable
                                ? "#f0f0f0"
                                : "white",
                              color:
                                selectedSize === size.id
                                  ? "rgb(159,137,219)"
                                  : !isAvailable
                                  ? "#ccc"
                                  : "black",
                              margin: "0 5px 0 0",
                              cursor: !isAvailable ? "not-allowed" : "pointer",
                            }}
                            onClick={() => isAvailable && setSelectedSize(size.id)}
                            disabled={!isAvailable}
                          >
                            {size.size}
                          </button>
                        );
                      })}
                    </div>
                  </div>
                  {/* Số lượng tồn kho */}
                  <div className="block-size">
                    <span style={{ fontFamily: "Raleway" }}>Số lượng tồn kho:</span>
                    {selectedVariant ? (
                      <span
                        style={{
                          fontFamily: "Raleway",
                          fontSize: "21px",
                          color: "rgb(159,134,217)",
                          fontStyle: "italic",
                          marginLeft:'5px'
                        }}
                      >
                        {selectedVariant.quantity}
                      </span>
                    ) : (
                      <span
                        style={{
                          fontFamily: "Raleway",
                          fontSize: "21px",
                          color: "rgb(159,134,217)",
                          fontStyle: "italic",
                        }}
                      >
                        Vui lòng chọn biến thể
                      </span>
                    )}
                  </div>
                  <div className="block-quantity">
                    {/* <div className="font-sm neutral-500 mb-15">Quantity</div> */}
                    <div className="box-form-cart">
                      <div className="form-cart">
                        <button
                          style={{
                            border: "1px solid gray",
                            borderRight: "none",
                          }}
                          className="minus"
                          onClick={handleDecrease}
                        >
                          <MinusOutlined />
                        </button>
                        <input
                          className="form-control"
                          type="text"
                          style={{ border: "1px solid gray", fontSize: "18px" }}
                          value={quantity}
                          readOnly
                        />
                        <button
                          style={{
                            border: "1px solid gray",
                            borderLeft: "none",
                          }}
                          className="plus"
                          onClick={handleIncrease}
                        >
                          <PlusOutlined />
                        </button>
                      </div>
                      <button
                        className="css-button-add"
                        onClick={() => handleAddToCart()}
                        disabled={!selectedColor || !selectedSize}
                      >
                        <ShoppingOutlined /> Thêm vào giỏ hàng
                      </button>
                    </div>
                  </div>
                  {/* <div className="box-product-tag d-flex justify-content-between align-items-end">
                                        <div className="box-tag-left">
                                            <p className="font-xs mb-5"><span className="neutral-500">SKU:</span><span className="neutral-900">kid1232568-UYV</span></p>
                                            <p className="font-xs mb-5"><span className="neutral-500">Categories:</span><span className="neutral-900">Girls, Dress</span></p>
                                            <p className="font-xs mb-5"><span className="neutral-500">Tags:</span><span className="neutral-900">fashion, dress, girls, blue</span></p>
                                        </div>
                                        <div className="box-tag-right">
                                            <span className="font-sm">Share:</span>
                                        </div>
                                    </div> */}
                </div>
              </div>
            </div>
            {/* Tab mô tả */}
            <div className="box-detail-product">
              <ul className="nav-tabs nav-tab-product" role="tablist">
                <li className="nav-item" role="presentation">
                  <button
                    style={{ fontFamily: "Raleway" }}
                    className="nav-link active"
                    id="description-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#description"
                    type="button"
                    role="tab"
                    aria-controls="description"
                    aria-selected="true"
                  >
                    Mô tả
                  </button>
                </li>
                <li className="nav-item" role="presentation">
                  <button
                    style={{ fontFamily: "Raleway" }}
                    className="nav-link"
                    id="vendor-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#vendor"
                    type="button"
                    role="tab"
                    aria-controls="vendor"
                    aria-selected="false"
                  >
                    Đánh giá
                  </button>
                </li>
              </ul>
              {/* Tab */}

              <div className="tab-content">
                <div
                  className="tab-pane fade show active"
                  id="description"
                  role="tabpanel"
                  aria-labelledby="description-tab"
                >
                  <span style={{ fontFamily: "Raleway", fontSize: "15px" }}>
                    {product.description}
                  </span>
                </div>
                {/* Đánh giá */}
                <div
                  className="tab-pane fade"
                  id="vendor"
                  role="tabpanel"
                  aria-labelledby="vendor-tab"
                >
                  <div className="table-responsive">
                    {/* Đánh giá */}
                    {product.reviews.map((review: any, index: any) => (
                      <>
                        <section className="layout-rating" key={index}>
                          <div>
                            <img
                              className="img-rating"
                              src={`${review.user_avatar}`}
                              alt=""
                            />
                          </div>
                          <div className="text-rating">
                            <span className="name-user">
                              {review.user_name}
                            </span>
                            {/* {dayjs(review.created_at).format('DD/MM/YYYY HH:mm:ss')} */}
                            <div className="star-ratings">
                              <Rate disabled defaultValue={review.rating} />
                            </div>
                            <p
                              style={{ fontSize: "14px" }}
                              className="content-rating"
                            >
                              {review.comment}
                            </p>
                          </div>
                        </section>
                        <hr className="hr-rating" />
                      </>
                    ))}

                    {/* end */}
                  </div>
                </div>
                {/* end */}
              </div>
            </div>
            {/* Sản phẩm cùng danh mục */}
            <section className="section block-may-also-like recent-viewed">
              <div className="container">
                <div className="top-head justify-content-center">
                  <h4 className="text-uppercase brand-1 brush-bg">
                    Sản phẩm liên quan
                  </h4>
                </div>
                <div className="row">
                  {productById.map((product, index) => (
                    <div className="col-lg-3 col-sm-6">
                      <Link to={`/product-detail/${product.id}`}>
                        <div className="cardProduct wow fadeInUp" key={index}>
                          <div className="cardImage">
                            {/* <label className="lbl-hot">hot</label> */}
                            <a href="product-single.html">
                              <img
                                className="imageMain"
                                src={product.avatar_url}
                                alt="kidify"
                              />
                              <img
                                className="imageHover"
                                src={product.avatar_url}
                                alt="kidify"
                              />
                            </a>
                            <div className="button-select">
                              <a href="product-single.html">Add to Cart</a>
                            </div>
                          </div>
                          <div className="cardInfo">
                            <h6
                              style={{
                                fontFamily: "Raleway",
                                fontWeight: "normal",
                              }}
                              className=" cardTitle"
                            >
                              {product.name}
                            </h6>
                            <p
                              style={{ fontFamily: "Raleway" }}
                              className="font-lg cardDesc"
                            >
                              {" "}
                              {Math.round(product.price).toLocaleString("vi", {
                                style: "currency",
                                currency: "VND",
                              })}
                            </p>
                          </div>
                        </div>
                      </Link>
                    </div>
                  ))}
                </div>
              </div>
            </section>
          </div>
        </section>
      </main>
    </>
  );
};

export default ProductDetailComponent;
