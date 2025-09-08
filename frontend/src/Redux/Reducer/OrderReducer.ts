import { createSlice, createAsyncThunk } from '@reduxjs/toolkit';
import axios from 'axios';
import api from '../../Axios/Axios';


export interface Order {
  user_id: string | null;
  total_amount: number;
  ship_method: number;
  payment_method: number;
  voucher_id: any;
  ship_address_id: number;
  status: number;
  order_items?: OrderItem[];
  sender_name?: string;
  phone_number?: string;
  subtotal?: number;
  totalPrice?: number;
}

interface OrderItem {
  product_variant_id: number;
  quantity: number;
  price: number;
}

interface OrderResponse {
  status: boolean;
  message: string;
  order_id?: string;
  total_amount?: number;
  order_details?: any[];
  payment_url?: string | { original: { payment_url: string } };
}

interface OrderState {
  orders: OrderResponse[];
  loading: boolean;
  error: string | null;
  payment_url?: string;
  payment_status?: string;  // Thêm trạng thái thanh toán
  payment_message?: string; // Thêm thông điệp thanh toán
}

const initialState: OrderState = {
  orders: [],
  loading: false,
  error: null,
  payment_url: undefined,
  payment_status: undefined,
  payment_message: undefined,
};

export const postOrder = createAsyncThunk<
  { order: OrderResponse, payment_url: string | undefined },
  Order,
  { rejectValue: string }
>(
  'order/postOrder',
  async (orderData: Order, { rejectWithValue }) => {
    const token = localStorage.getItem('token');
    if (!token) {
      return rejectWithValue('No token found');
    }
    try {
      const response = await axios.post('http://127.0.0.1:8000/api/orders', orderData, {
        headers: { Authorization: `Bearer ${token}` },
      });
      
      const responseData: OrderResponse = response.data;
      
      // Xử lý payment_url một cách an toàn
      let paymentUrl: string | undefined;
      if (responseData.payment_url) {
        if (typeof responseData.payment_url === 'string') {
          paymentUrl = responseData.payment_url;
        } else if (responseData.payment_url.original?.payment_url) {
          paymentUrl = responseData.payment_url.original.payment_url;
        }
      }
      
      return { 
        order: responseData, 
        payment_url: paymentUrl 
      };
    } catch (error: any) {
      console.error('Error posting order:', error);
      return rejectWithValue(error.response?.data || 'Something went wrong');
    }
  }
);

export const fetchPaymentStatus = createAsyncThunk<
  { status: string, message: string },
  string,
  { rejectValue: string }
>(
  'order/fetchPaymentStatus',
  async (queryParams: string, { rejectWithValue }) => {
    try {
      const response = await axios.get(`http://127.0.0.1:8000/api/payment/result${queryParams}`);
      return { status: response.data.status, message: response.data.message };
    } catch (error: any) {
      console.error('Error fetching payment status:', error);
      return rejectWithValue(error.response?.data || 'Something went wrong');
    }
  }
);

const OrderReducer = createSlice({
  name: 'order',
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder
      .addCase(postOrder.pending, (state) => {
        state.loading = true;
        state.error = null;
      })
      .addCase(postOrder.fulfilled, (state, action) => {
        state.loading = false;
        state.orders.push(action.payload.order);
        state.payment_url = action.payload.payment_url;
      })
      .addCase(postOrder.rejected, (state, action) => {
        state.loading = false;
        state.error = action.error.message || 'Đã xảy ra lỗi!';
      })
      .addCase(fetchPaymentStatus.pending, (state) => {
        state.loading = true;
        state.error = null;
      })
      .addCase(fetchPaymentStatus.fulfilled, (state, action) => {
        state.loading = false;
        state.payment_status = action.payload.status;
        state.payment_message = action.payload.message;
      })
      .addCase(fetchPaymentStatus.rejected, (state, action) => {
        state.loading = false;
        state.error = action.error.message || 'Đã xảy ra lỗi!';
      });
  },
});

export default OrderReducer.reducer;
