<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <BreadcrumbComponent :titlePage="state.pageTitle" />
        <form @submit.prevent="onSubmit">
          <a-row :gutter="16">
            <a-col :span="16">
              <a-card class="mt-3" title="Thông tin chung">
                <AleartError :errors="state.error" />
                <a-row :gutter="[16, 16]">
                  <a-col :span="24">
                    <InputComponent
                      label="Tên kho hàng"
                      :required="true"
                      name="name"
                      placeholder="Kho + Vị trí. Ví dụ: Kho Hoàng Mai, Kho Hà Nam, ..."
                    />
                  </a-col>

                  <a-col :span="12">
                    <InputComponent
                      label="Số điện thoại"
                      :required="true"
                      name="phone"
                      placeholder="Số điện thoại"
                    />
                  </a-col>

                  <a-col :span="12">
                    <InputComponent
                      label="Người quản lý"
                      :required="true"
                      name="supervisor_name"
                      placeholder="Tên người quản lý"
                    />
                  </a-col>

                  <a-col :span="24">
                    <InputComponent
                      label="Địa chỉ"
                      :required="true"
                      name="address"
                      placeholder="Địa chỉ kho hàng"
                    />
                  </a-col>

                  <a-col :span="24">
                    <InputComponent
                      typeInput="textarea"
                      label="Ghi chú"
                      name="description"
                      placeholder="Ghi chú"
                    />
                  </a-col>
                </a-row>
              </a-card>
            </a-col>
            <a-col :span="8">
              <ConfigView @on-change-config-warehouse="handleChangeConfigWarehouse" />
            </a-col>
          </a-row>

          <div class="fixed bottom-0 right-[19px] p-10">
            <a-button html-type="submit" type="primary">
              <i class="far fa-save mr-2"></i>
              <span>Lưu thông tin</span>
            </a-button>
          </div>
        </form>
      </div>
    </template>
  </MasterLayout>
</template>

<script setup>
import {
  MasterLayout,
  BreadcrumbComponent,
  AleartError,
  InputComponent
} from '@/components/backend';
import { computed, onMounted, reactive } from 'vue';
import { useForm } from 'vee-validate';
import { useStore } from 'vuex';
import { formatMessages } from '@/utils/format';
import * as yup from 'yup';
import router from '@/router';
import { useCRUD } from '@/composables';
import ConfigView from './partials/ConfigView.vue';

const store = useStore();
const id = computed(() => router.currentRoute.value.params.id || null);
const { getOne, create, update, messages, data } = useCRUD();

// STATE
const state = reactive({
  endpoint: 'warehouses',
  pageTitle: 'Thêm mới kho hàng',
  isConfigWarehouse: true,
  error: {}
});

const validationSchema = computed(() => {
  return yup.object({
    name: yup.string().required('Tên kho hàng không được để trống.'),
    address: yup.string().required('Địa chỉ kho hàng không được để trống.'),
    supervisor_name: yup.string().required('Tên người quản lý không được để trống.'),
    phone: yup
      .string()
      .required('Số điện thoại không được để trống.')
      .matches(/(0)[0-9]{9}/, 'Số điện thoại không đúng định dạng.'),
    aisles_number: state.isConfigWarehouse
      ? yup.number().required('Số dãy không được để trống.')
      : yup.number().nullable().notRequired(),
    racks_number: state.isConfigWarehouse
      ? yup.number().required('Số kệ không được để trống.')
      : yup.number().nullable().notRequired(),
    shelves_number: state.isConfigWarehouse
      ? yup.number().required('Số tầng không được để trống.')
      : yup.number().nullable().notRequired(),
    compartments_number: state.isConfigWarehouse
      ? yup.number().required('Số khoang không được để trống.')
      : yup.number().nullable().notRequired()
  });
});

const { handleSubmit, setValues } = useForm({
  validationSchema
});

const handleChangeConfigWarehouse = (value) => {
  state.isConfigWarehouse = value;
  console.log(state.isConfigWarehouse);
};

const onSubmit = handleSubmit(async (values) => {
  state.error = {};

  const response =
    id.value && id.value > 0
      ? await update(state.endpoint, id.value, values)
      : await create(state.endpoint, values);
  if (!response) {
    return (state.error = formatMessages(messages.value));
  }
  store.dispatch('antStore/showMessage', { type: 'success', message: messages.value });
  router.push({ name: 'warehouse.index' });
});

const fetchOne = async () => {
  await getOne(state.endpoint, id.value);
  setValues({
    name: data.value?.name,
    code: data.value?.code,
    email: data.value?.email,
    phone: data.value?.phone,
    address: data.value?.address,
    aisles_number: data.value?.aisles_number,
    racks_number: data.value?.racks_number,
    shelves_number: data.value?.shelves_number,
    compartments_number: data.value?.compartments_number,
    supervisor_name: data.value?.supervisor_name,
    description: data.value?.description
  });
};

onMounted(async () => {
  if (id.value) {
    fetchOne();
    state.pageTitle = 'Cập nhập kho hàng.';
  }
});
</script>
