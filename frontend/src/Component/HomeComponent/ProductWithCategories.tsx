import api from "../../Axios/Axios";
import { Pagination } from "antd";
import { useState, useEffect } from "react";
import { IProduct } from "../../types/cart";
import type { PaginationProps } from "antd";
import { Link } from "react-router-dom";
const ProductWithCategories: React.FC = () => {
  const [products, setProducts] = useState<IProduct[]>([]);
  const [Newproducts, setNewProducts] = useState<IProduct[]>([]);
  const [Topproducts, setTopProducts] = useState<IProduct[]>([]);
  const pageSize = 8;
  const [current, setCurrent] = useState(1);

  const onChange: PaginationProps["onChange"] = (page) => {
    console.log(page);
    setCurrent(page);
  };

  const GetProductCategory = async () => {
    try {
      const { data } = await api.get(`/products`);
      setProducts(data.products);
    } catch (error) {
      console.log(error);
    }
  };

  const paginatedProducts = products.slice(
    (current - 1) * pageSize,
    current * pageSize
  );

  const GetNewProducts = async () => {
    try {
      const { data } = await api.get(`/newproduct`);
      setNewProducts(data.products);
    } catch (error) {
      console.log(error);
    }
  };

  const paginatedNewProducts = Newproducts.slice(
    (current - 1) * pageSize,
    current * pageSize
  );

  const GetTopProducts = async () => {
    try {
      const { data } = await api.get(`/topsell`);
      setTopProducts(data.products);
    } catch (error) {
      console.log(error);
    }
  };

  const paginatedTopProducts = Topproducts.slice(
    (current - 1) * pageSize,
    current * pageSize
  );

  // const boyProducts = products.filter(
  //   (product) => product.categories.name === "Nam"
  // );
  // const girlProducts = products.filter(
  //   (product) => product.categories.name === "Nữ"
  // );
  // const kidProducts = products.filter(
  //   (product) => product.categories.name === "Trẻ em"
  // );

  useEffect(() => {
    GetProductCategory();
    GetNewProducts();
    GetTopProducts();
  }, []);

  return (
    <>
      <section className="section block-section-1">
        <div className="container">
          <div className="text-center">
            <p className="font-xl brand-2 wow animate__animated animate__fadeIn">
              <span className="rounded-text">NEW IN STORE</span>
            </p>
            <div className="box-tabs wow animate__animated animate__fadeIn">
              <ul className="nav nav-tabs" role="tablist">
                <li className="nav-item" role="presentation">
                  <button
                    className="nav-link active"
                    id="girls-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#girls"
                    type="button"
                    role="tab"
                    aria-controls="girls"
                    aria-selected="true"
                  >
                    Tất cả sản phẩm
                  </button>
                </li>
                <li className="nav-item" role="presentation">
                  <button
                    className="nav-link"
                    id="boys-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#boys"
                    type="button"
                    role="tab"
                    aria-controls="boys"
                    aria-selected="false"
                  >
                    Sản phẩm bán chạy nhất
                  </button>
                </li>
                <li className="nav-item" role="presentation">
                  <button
                    className="nav-link"
                    id="accessories-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#accessories"
                    type="button"
                    role="tab"
                    aria-controls="accessories"
                    aria-selected="false"
                  >
                    Sản phẩm mới về
                  </button>
                </li>
              </ul>
            </div>
          </div>
          {/* sản phẩm theo danh mục */}
          <div className="tab-content">
            <div
              className="tab-pane fade show active"
              id="girls"
              role="tabpanel"
              aria-labelledby="girls-tab"
            >
              <div className="row">
                {paginatedProducts.map((product) => (
                  <div
                    key={product.id}
                    className="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn"
                    data-wow-delay=".5s"
                  >
                    <Link to={`/product-detail/${product.id}`}>
                      <div className="cardProduct wow fadeInUp" style={{ height: '100%' }}>
                        <div className="cardImage" style={{ height: '270px', overflow: 'hidden' }}>
                          {/* <label className="lbl-hot">hot</label> */}
                          <div style={{ height: '100%' }}>
                            <img
                              className="imageMain"
                              src={product.avatar_url}
                              alt="kidify"
                              style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                            />
                            <img
                              className="imageHover"
                              src={product.avatar_url}
                              alt="kidify"
                              style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                            />
                          </div>
                          <div className="button-select">
                            <a href="#">Add to Cart</a>
                          </div>
                        </div>
                        <div className="cardInfo">
                          <h6 className="font-md-bold cardTitle">
                            {product.name}
                          </h6>
                          <p className="font-lg cardDesc">
                            {" "}
                            {Math.round(product.price ?? 0).toLocaleString(
                              "vi-VN",
                              { style: "currency", currency: "VND" }
                            )}
                          </p>
                        </div>
                      </div>
                    </Link>
                  </div>
                ))}
              </div>
            </div>
            <div
              className="tab-pane fade"
              id="boys"
              role="tabpanel"
              aria-labelledby="boys-tab"
            >
              <div className="row">
                {paginatedTopProducts.map((product) => (
                  <div
                    key={product.id}
                    className="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn"
                    data-wow-delay=".1s"
                  >
                    <Link to={`/product-detail/${product.id}`}>
                      <div className="cardProduct wow fadeInUp" style={{ height: '100%' }}>
                        <div className="cardImage" style={{ height: '270px', overflow: 'hidden' }}>
                          <label className="lbl-hot">hot</label>
                          <div style={{ height: '100%' }}>
                            <img
                              className="imageMain"
                              src={product.avatar_url}
                              alt="kidify"
                              style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                            />
                            <img
                              className="imageHover"
                              src={product.avatar_url}
                              alt="kidify"
                              style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                            />
                          </div>
                          <div className="button-select">
                            <a href="#">Add to Cart</a>
                          </div>
                        </div>
                        <div className="cardInfo">
                          <h6 className="font-md-bold cardTitle">
                            {product.name}
                          </h6>
                          <p className="font-lg cardDesc">
                            {Math.round(product.price ?? 0).toLocaleString(
                              "vi-VN",
                              { style: "currency", currency: "VND" }
                            )}
                          </p>
                          <p className="font-sm text-success mb-0">
                            Đã bán: <b>{product.total_sold}</b>
                          </p>
                        </div>
                      </div>
                    </Link>
                  </div>
                ))}
              </div>
            </div>

            <div
              className="tab-pane fade"
              id="accessories"
              role="tabpanel"
              aria-labelledby="children"
            >
              <div className="row">
                {paginatedNewProducts.map((product) => (
                  <div
                    key={product.id}
                    className="col-xl-3 col-lg-4 col-md-6 col-sm-6 wow animate__animated animate__fadeIn"
                    data-wow-delay=".1s"
                  >
                    <Link to={`/product-detail/${product.id}`}>
                      <div className="cardProduct wow fadeInUp" style={{ height: '100%' }}>
                        <div className="cardImage" style={{ height: '270px', overflow: 'hidden' }}>
                          <label className="lbl-hot">new</label>
                          <div style={{ height: '100%' }}>
                            <img
                              className="imageMain"
                              src={product.avatar_url}
                              alt="kidify"
                              style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                            />
                            <img
                              className="imageHover"
                              src={product.avatar_url}
                              alt="kidify"
                              style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                            />
                          </div>
                          <div className="button-select">
                            <a href="#">Add to Cart</a>
                          </div>
                        </div>
                        <div className="cardInfo">
                          <h6 className="font-md-bold cardTitle">
                            {product.name}
                          </h6>
                          <p className="font-lg cardDesc">
                            {" "}
                            {Math.round(product.price ?? 0).toLocaleString(
                              "vi-VN",
                              { style: "currency", currency: "VND" }
                            )}
                          </p>
                        </div>
                      </div>
                    </Link>
                  </div>
                ))}
              </div>
            </div>
          </div>
          <nav className="box-pagination" style={{ float: "right" }}>
            <Pagination
              current={current}
              onChange={onChange}
              total={products.length}
              pageSize={pageSize}
            />
          </nav>
        </div>
      </section>
    </>
  );
};

export default ProductWithCategories;
