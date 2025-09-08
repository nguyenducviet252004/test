export type IOrder = {
  user_id: string;
  total_amount: number;
  ship_address_id: number;
  phone_number: string;
  subtotal: number;
  voucher_id: number | null;
  totalPrice: number;
  status: number;
  ship_method: number;
  payment_method: number;
  order_items: any[];
  sender_name?: string; // Thêm trường người gửi
};
