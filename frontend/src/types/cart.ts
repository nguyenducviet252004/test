export type Cart = {
    user_id: number;
    // This type seems to be for a general cart, not cart items.
    // I will define ICartItem below.
  };

export type ICartItem = {
    id: string;
    product_id: string;
    product_variant_id: string;
    product_name: string;
    avatar: string;
    color: string;
    size: string;
    quantity: number;
    price: number;
    total: number;
  };

export type IProductVariant = {
    id: number;
    product_id: number;
    size_id: number;
    color_id: number;
    quantity: number;
    price: number;
    price_sale: number;
    created_at: string;
    updated_at: string;
  };
export type Category = {
    id: number;
    name: string;
  };


export type Gallery = {
    id: string;
    image_path: string
}
export type IProduct = {
    id: string;
    name: string;
    slug?: string; // Added slug
    avatar_url: string;
    categories: Category;
    sizes: Size[];
    colors: Color[];
    galleries: Gallery[];
    view?: number;
    price: number; // This will be min_price from variants
    description: string;
    display: number;
    status: number;
    deleted_at?: string; // Added deleted_at
    created_at: string;
    updated_at: string;
    total_sold?: number; // Thêm trường số lượng đã bán cho sản phẩm bán chạy
  };
  export type UserCart = {
    id: string;
    usename: string;
    fullname: string;

  };

 export interface Color {
    id: number;
    name_color: string;
    pivot: {
      product_id: number;
      color_id: number;
    };
  }
  
 export interface Size {
    id: number;
    size: string; 
    pivot: {
      product_id: number;
      size_id: number;
    };
  }
