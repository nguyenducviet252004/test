import Arrow from "../../assets/imgs/template/icons/arrow-hover.svg";
import ArrowHover from "../../assets/imgs/template/icons/arrow-hover.svg";
import Ig from "../../assets/imgs/page/homepage1/Ao-bong-da-bayern-munich-san-nha-1.jpg";
import IgOne from "../../assets/imgs/page/homepage1/Ao-bong-da-real-madrid-san-nha-2425-1.jpg";
import IgThree from "../../assets/imgs/page/homepage1/htt4714.png";
import IgFour from "../../assets/imgs/page/homepage1/Ao-doi-tuyen-phap-san-nha-1.jpg";
import IgTwo from "../../assets/imgs/page/homepage1/photo-2024-06-26-13-22-53-1719385515835.jpg";
import IgFive from "../../assets/imgs/page/homepage1/photo-2024-06-26-13-22-53-1719385515835.jpg";
import { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { Pagination } from "antd";
import type { PaginationProps } from "antd";
import axios from "axios";
import "./new.css";
const New: React.FC = () => {
  const [blog, setBlog] = useState<any[]>([]);
  const [blog4, setBlog4] = useState<any>();
  const pageSize = 3;
  const [current, setCurrent] = useState(1);

  const onChange: PaginationProps["onChange"] = (page) => {
    setCurrent(page);
  };

  useEffect(() => {
    const GetLogo = async () => {
      try {
        const { data } = await axios.get(`http://127.0.0.1:8000/api/blog`);
        setBlog(data);
      } catch (error) {
        console.error("Lỗi khi tải blog:", error);
      }
    };
    const GetQuangCao = async () => {
      try {
        const { data } = await axios.get(
          `http://127.0.0.1:8000/api/logobanner/6`
        );
        setBlog4(data);
      } catch (error) {
        console.error("Lỗi khi tải banner quảng cáo:", error);
      }
    };
    GetLogo();
    GetQuangCao();
  }, []);


  const paginatedBlog = blog.slice(
    (current - 1) * pageSize,
    current * pageSize
  );

  const maxLength = 140;
  const truncateText = (text: any) => {
    if (text.length > maxLength) {
      return text.substring(0, maxLength) + "...";
    }
    return text;
  };

  const [isOpen, setIsOpen] = useState(true);
  const closeModal = (e: React.MouseEvent) => {
    e.preventDefault();
    setIsOpen(false);
  };
  return (
    <>
      <section className="section block-section-8">
        <div className="container">
          <div className="text-center">
            <h4 className="text-uppercase brand-1 mb-15 brush-bg wow animate__fadeIn animated">
              Tin tức và sự kiện mới nhất
            </h4>
            <p className="font-lg neutral-500 mb-30 wow animate__animated animate__fadeIn">
              Đừng bỏ lỡ những tin tức khuyến mại tuyệt vời hoặc
              <br className="d-none d-lg-block" />
              các sự kiện sắp tới trong hệ thống cửa hàng của chúng tôi
            </p>
          </div>
          <div className="row">
            {paginatedBlog.map((b, index) => (
              <div
                key={index}
                className="col-lg-4 col-md-6 wow animate__animated animate__fadeIn"
                data-wow-delay="0s"
              >
                <Link to={`/blog-detail/${b.id}`}>
                  <div className="cardBlog wow fadeInUp">
                    <div className="cardImage">
                      {/* <div className="box-date-info">
                                        <div className="box-inner-date">
                                            <div className="heading-6">21</div>
                                            <p className="font-md neutral-900">Jun</p>
                                        </div>
                                    </div> */}
                      <div>
                        <img
                          src={b.image}
                          alt="kidify"
                          style={{ width: "100%", height: "350px" }}
                        />
                      </div>
                    </div>
                    <div className="cardInfo">
                      <div className="cardTitle">
                        <h5 className="font-xl-bold">{b.title}</h5>
                      </div>
                      <p className="cardDesc font-lg neutral-500">
                        {truncateText(b.description)}
                      </p>
                      <div className="btn btn-arrow-right">
                        Xem chi tiết
                        <img src={Arrow} alt="Kidify" />
                        <img
                          className="hover-icon"
                          src={ArrowHover}
                          alt="Kidify"
                        />
                      </div>
                    </div>
                  </div>
                </Link>
              </div>
            ))}
          </div>
          <nav className="box-pagination" style={{ float: "right" }}>
            <Pagination
              current={current}
              onChange={onChange}
              total={blog.length}
              pageSize={pageSize}
            />
          </nav>
        </div>
      </section>
      <section className="section block-section-10">
        <div className="container">
          <div className="top-head justify-content-center">
            <h4 className="text-uppercase brand-1 wow fadeInDown">
              instagram feed
            </h4>
          </div>
        </div>
        <div className="box-gallery-instagram">
          <div className="box-gallery-instagram-inner">
            <div className="gallery-item wow fadeInLeft">
              <img src={Ig} alt="kidify" />
            </div>
            <div className="gallery-item wow fadeInUp">
              <img src={IgTwo} alt="kidify" />
            </div>
            <div className="gallery-item wow fadeInUp">
              <img src={IgThree} alt="kidify" />
            </div>
            <div className="gallery-item wow fadeInUp">
              <img src={IgFour} alt="kidify" />
            </div>
            <div className="gallery-item wow fadeInRight">
              <img src={IgFive} alt="kidify" />
            </div>
            <div className="gallery-item wow fadeInRight">
              <img src={IgOne} alt="kidify" />
            </div>
          </div>
        </div>
      </section>
      {/* Quảng cáo  */}
      {blog4 && (
        <div>
          {isOpen && blog4 && (
            <div
              style={{
                position: "fixed",
                top: 0,
                left: 0,
                width: "100vw",
                height: "100vh",
                background: "rgba(0,0,0,0.3)",
                zIndex: 9999,
                display: "flex",
                alignItems: "center",
                justifyContent: "center"
              }}
            >
              <div
                style={{
                  position: "relative",
                  background: "#fff",
                  borderRadius: "12px",
                  padding: 0,
                  width: "600px",
                  maxWidth: "95vw",
                  boxShadow: "0 2px 16px rgba(0,0,0,0.2)"
                }}
              >
                <button
                  onClick={closeModal}
                  style={{
                    position: "absolute",
                    top: 10,
                    right: 10,
                    background: "#fff",
                    border: "none",
                    fontSize: 24,
                    cursor: "pointer",
                    zIndex: 2
                  }}
                >
                  ×
                </button>
                <img
                  src={blog4.image}
                  alt={blog4.title}
                  style={{
                    width: "100%",
                    height: "350px",
                    objectFit: "cover",
                    borderRadius: "12px 12px 0 0",
                    display: "block"
                  }}
                />
                <div style={{ padding: "24px 32px 24px 32px", textAlign: "center" }}>
                  <h2 style={{ margin: 0, fontSize: 28 }}>{blog4.title}</h2>
                  <p style={{ margin: "8px 0 16px 0", fontSize: 18 }}>{blog4.description}</p>
                  <a href="/product" className="btn btn-primary" style={{ background: "#222", color: "#fff", padding: "10px 28px", borderRadius: 6, fontWeight: 600, textDecoration: "none", fontSize: 18 }}>
                    Mua sắm ngay
                  </a>
                </div>
              </div>
            </div>
          )}
        </div>
      )}
    </>
  );
};
export default New;
