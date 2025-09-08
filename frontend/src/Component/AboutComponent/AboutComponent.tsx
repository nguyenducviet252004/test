import About from '../../assets/imgs/page/about/MU.png'
import Tick from '../../assets/imgs/page/about/tick.png'
import Gallery from '../../assets/imgs/page/about/MU.jpg'
import GalleryTwo from '../../assets/imgs/page/about/gallery2.png'
import GalleryThree from '../../assets/imgs/page/about/gallery3.png'
import GalleryFour from '../../assets/imgs/page/about/MU.jpg'
import GalleryFive from '../../assets/imgs/page/about/gallery5.png'
import Ig from "../../assets/imgs/page/homepage1/Ao-bong-da-bayern-munich-san-nha-1.jpg";
import IgOne from "../../assets/imgs/page/homepage1/Ao-bong-da-real-madrid-san-nha-2425-1.jpg";
import IgThree from "../../assets/imgs/page/homepage1/htt4714.png";
import IgFour from "../../assets/imgs/page/homepage1/Ao-doi-tuyen-phap-san-nha-1.jpg";
import IgTwo from "../../assets/imgs/page/homepage1/photo-2024-06-26-13-22-53-1719385515835.jpg";
import IgFive from "../../assets/imgs/page/homepage1/photo-2024-06-26-13-22-53-1719385515835.jpg";
import Star from '../../assets/imgs/template/icons/star.svg'
import Avatar from '../../assets/imgs/page/homepage2/avatar-review.png'
import { Swiper, SwiperSlide } from 'swiper/react';
import { Pagination } from 'swiper/modules';
const AboutComponent: React.FC = () => {

    return (
        <>
            <main className="main">
                <section className="section block-blog-single">
                    <div className="container">
                        <div className="top-head-blog">
                            <div className="text-center">
                                <h2 className="font-4xl-bold">Giới thiệu về chúng tôi</h2>
                                <div className="breadcrumbs d-inline-block">
                                    <ul>
                                        <li><a href="#">Trang chủ</a></li>
                                        <li><a href="#">Tin tức</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div className="feature-image"><img src={About} alt="kidify" /></div>
                        <div className="content-detail">
                            <h2>Câu Chuyện Của Chúng Tôi: Từ Sân Cỏ Đến Giấc Mơ</h2>
                            <p />
                            <p><strong>Là một tín đồ của môn thể thao vua, chúng ta hiểu rằng niềm đam mê không chỉ dừng lại sau 90 phút trên sân. Cảm giác được khoác lên mình màu áo của đội bóng yêu thích, dù là khi ra sân thi đấu hay khi hòa mình vào một trận cầu đỉnh cao trên TV, là một trải nghiệm đầy tự hào.</strong></p>
                            <p>Tuy nhiên, sự hưng phấn của trận đấu thường khiến bạn không muốn cởi bỏ bộ trang phục thi đấu ngay lập tức. Nhưng những bộ quần áo đấu truyền thống lại không phải lúc nào cũng mang lại sự thoải mái cho những phút giây thư giãn sau đó.

Vậy sẽ ra sao nếu có những bộ quần áo bóng đá vừa thể hiện trọn vẹn tinh thần sân cỏ, vừa mang lại sự thoải mái tuyệt đối để bạn có thể mặc trong mọi hoạt động hàng ngày? Điều này sẽ mang đến một trải nghiệm liền mạch, giúp bạn sống trọn từng khoảnh khắc với đam mê của mình. Trong bài viết này, chúng ta sẽ cùng khám phá những bộ trang phục bóng đá đa năng có thể làm được điều đó.</p>
                            <div className="box-experiences">
                                <div className="row">
                                    <div className="col-lg-4"><strong className="font-xl-bold">12 năm</strong>
                                        <p className="font-md neutral-500">Chúng tôi có hơn 12 năm kinh nghiệm làm việc.</p>
                                    </div>
                                    <div className="col-lg-4"><strong className="font-xl-bold">2000+ Nhân viên</strong>
                                        <p className="font-md neutral-500">Chúng tôi có hơn 2000 nhân viên làm việc gần bạn.</p>
                                    </div>
                                    <div className="col-lg-4"><strong className="font-xl-bold">68 Chi nhánh</strong>
                                        <p className="font-md neutral-500">Chúng tôi có 68 chi nhánh trên toàn quốc và đang mở rộng</p>
                                    </div>
                                </div>
                            </div>
                            <h2>Sứ mệnh của chúng tôi</h2>
                            <p>Việc phải thay đổi trang phục ngay sau trận đấu có thể làm gián đoạn mạch cảm xúc. Nhưng sẽ ra sao nếu có những bộ quần áo bóng đá vừa giúp bạn cháy hết mình cùng trận đấu, vừa đủ thoải mái để bạn tiếp tục các hoạt động thư giãn ngay sau đó? Điều này sẽ giúp trải nghiệm hâm mộ của bạn trở nên liền mạch và trọn vẹn hơn rất nhiều! Sứ mệnh của chúng tôi là tạo ra những bộ trang phục có thể làm được điều đó.</p>
                        </div>
                    </div>
                    <div className="box-gallery-about">
                        <div className="container-1190">
                            <h2 className="font-3xl-bold mb-55">Phòng trưng bày của chúng tôi</h2>
                            <div className="box-gallery-list">
                                <div className="gallery-main"><a className="glightbox" href={Gallery}><img src={Gallery} alt="kidify" /></a></div>
                                <div className="gallery-sub"><a className="glightbox" href={GalleryTwo}><img src={GalleryTwo} alt="kidify" /></a><a className="glightbox" href={GalleryThree}><img src={GalleryThree} alt="kidify" /></a><a className="glightbox" href={GalleryFour}><img src={GalleryFour} alt="kidify" /></a><a className="glightbox" href={GalleryFive}><img src={GalleryFive} alt="kidify" /></a></div>
                            </div>
                        </div>
                    </div>
                    {/* <div className="box-reviews-about"> */}
                        <div className="content-detail mb-20">
                            <h2 className="font-3xl-bold">Phong tục hạnh phúc của chúng tôi</h2>
                        </div>
                        <div className="feature-image mb-0"><span className="title-left" /></div>
                        {/* <div className="box-slider-about box-slide-padding-left">
                            <div className="box-swiper">
                                <div className="swiper-container swiper-auto pt-35">
                                    <div className="swiper-wrapper">
                                        <Swiper
                                            modules={[Pagination]} // Sử dụng module Pagination
                                            slidesPerView={3} // Chỉnh số slide hiển thị trên mỗi trang
                                            pagination={{ clickable: true }} // Bật pagination
                                            className="swiper-9-items pb-0"
                                        >

<SwiperSlide>
                                            <div className="swiper-slide">
                                                <div className="cardReview">
                                                    <div className="cardRating"><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /></div>
                                                    <div className="cardReviewText">
                                                        <p className="font-sm neutral-900">"I recently discovered this fashion shop and I am obsessed! The clothes are of great quality and the designs are unique and stylish. I always receive compliments whenever I wear something from this store. Definitely my new go-to for trendy outfits.</p>
                                                    </div>
                                                    <div className="cardAuthor"><img src={Avatar} alt="kidify" /><span className="font-lg-bold brand-1">Sarah L</span></div>
                                                </div>
                                            </div>
                                        </SwiperSlide>
                                        <SwiperSlide>
                                            <div className="swiper-slide">
                                                <div className="cardReview">
                                                    <div className="cardRating"><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /></div>
                                                    <div className="cardReviewText">
                                                        <p className="font-sm neutral-900">"I recently discovered this fashion shop and I am obsessed! The clothes are of great quality and the designs are unique and stylish. I always receive compliments whenever I wear something from this store. Definitely my new go-to for trendy outfits.</p>
                                                    </div>
                                                    <div className="cardAuthor"><img src={Avatar} alt="kidify" /><span className="font-lg-bold brand-1">Sarah L</span></div>
                                                </div>
                                            </div>
                                        </SwiperSlide>
                                        <SwiperSlide>
                                            <div className="swiper-slide">
                                                <div className="cardReview">
                                                    <div className="cardRating"><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /></div>
                                                    <div className="cardReviewText">
                                                        <p className="font-sm neutral-900">"I recently discovered this fashion shop and I am obsessed! The clothes are of great quality and the designs are unique and stylish. I always receive compliments whenever I wear something from this store. Definitely my new go-to for trendy outfits.</p>
                                                    </div>
                                                    <div className="cardAuthor"><img src={Avatar} alt="kidify" /><span className="font-lg-bold brand-1">Sarah L</span></div>
                                                </div>
                                            </div>
                                        </SwiperSlide>
                                        <SwiperSlide>
                                            <div className="swiper-slide">
                                                <div className="cardReview">
                                                    <div className="cardRating"><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /></div>
                                                    <div className="cardReviewText">
                                                        <p className="font-sm neutral-900">"I recently discovered this fashion shop and I am obsessed! The clothes are of great quality and the designs are unique and stylish. I always receive compliments whenever I wear something from this store. Definitely my new go-to for trendy outfits.</p>
                                                    </div>
                                                    <div className="cardAuthor"><img src={Avatar} alt="kidify" /><span className="font-lg-bold brand-1">Sarah L</span></div>
                                                </div>
                                            </div>
                                        </SwiperSlide>
                                        <SwiperSlide>
                                            <div className="swiper-slide">
                                                <div className="cardReview">
                                                    <div className="cardRating"><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /></div>
                                                    <div className="cardReviewText">
                                                        <p className="font-sm neutral-900">"I recently discovered this fashion shop and I am obsessed! The clothes are of great quality and the designs are unique and stylish. I always receive compliments whenever I wear something from this store. Definitely my new go-to for trendy outfits.</p>
                                                    </div>
                                                    <div className="cardAuthor"><img src={Avatar} alt="kidify" /><span className="font-lg-bold brand-1">Sarah L</span></div>
                                                </div>
                                            </div>
                                        </SwiperSlide>
                                        <SwiperSlide>
                                            <div className="swiper-slide">
                                                <div className="cardReview">
                                                    <div className="cardRating"><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /><img src={Star} alt="kidify" /></div>
                                                    <div className="cardReviewText">
                                                        <p className="font-sm neutral-900">"I recently discovered this fashion shop and I am obsessed! The clothes are of great quality and the designs are unique and stylish. I always receive compliments whenever I wear something from this store. Definitely my new go-to for trendy outfits.</p>
                                                    </div>
                                                    <div className="cardAuthor"><img src={Avatar} alt="kidify" /><span className="font-lg-bold brand-1">Sarah L</span></div>
                                                </div>
                                            </div>
                                        </SwiperSlide>
                                        </Swiper>
                                 

                                    </div>
                                </div>
                                <div className="box-pagination-button box-pagination-button-center">
                                    <div className="swiper-pagination swiper-pagination-banner swiper-pagination-auto" />
                                </div>
                            </div>
                        </div>
                    </div> */}
                    <div className="container">
                        <div className="content-detail">
                            <h2>Câu chuyện của chúng tôi</h2>
                            <p>Đây là bài tập cơ bản nhất mà bạn có thể bỏ qua và có thể thực hiện công việc của mình như một công việc khó khăn. Bạn có thể bị buộc tội lao động, có phải đối mặt với điều này không phải là điều đáng tiếc và sự bất tiện mà bạn có thể gặp phải?</p>
                        </div>
                    </div>
                </section>
                <section className="section block-section-10">
                    <div className="container">
                        <div className="top-head justify-content-center">
                            <h4 className="text-uppercase brand-1 wow fadeInDown">instagram feed</h4>
                        </div>
                    </div>
                    <div className="box-gallery-instagram">
                        <div className="box-gallery-instagram-inner">
                            <div className="gallery-item wow fadeInLeft"><img src={Ig} alt="kidify" /></div>
                            <div className="gallery-item wow fadeInUp"><img src={IgTwo} alt="kidify" /></div>
                            <div className="gallery-item wow fadeInUp"><img src={IgThree} alt="kidify" /></div>
                            <div className="gallery-item wow fadeInUp"><img src={IgFour} alt="kidify" /></div>
                            <div className="gallery-item wow fadeInRight"><img src={IgFive} alt="kidify" /></div>
                            <div className="gallery-item wow fadeInRight"><img src={IgOne} alt="kidify" /></div>
                        </div>
                    </div>
                </section>
            </main>

        </>
    )
}
export default AboutComponent