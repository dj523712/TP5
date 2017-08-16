// import dva from 'dva';

export default {
  namespace: 'products',
  state: [],
  reducers: {
    'delete'(state, { payload: id }) {  // eslint-disable-line
      return state.filter(item => item.id !== id);
    },
  },
};
