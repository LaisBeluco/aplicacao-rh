<script setup lang="ts">
import type { EmployeeProps } from "@/utils/types";
import { Sheet, SheetDescription, SheetContent, SheetHeader, SheetFooter, SheetTitle } from "./sheet"
import Label from "./label/Label.vue"
import Input from "./input/Input.vue"
import { computed } from "vue";

type PickedProps = "code" | "full_name" | "document" | "date_birth" | "user_name" | "mother_name" | "father_name" | "role";
interface CustomEmployeeProps extends Pick<EmployeeProps, PickedProps> {
}

const props = defineProps<{ open: boolean; employee?: EmployeeProps }>();
const emit = defineEmits(["update:open", "refresh-data"]);

let form = reactive<CustomEmployeeProps>({
  code: "",
  full_name: "",
  user_name: "",
  document: "",
  date_birth: "",
  mother_name: "",
  father_name: "",
  role: ""
});

const isSubmitting = ref(false);


const addNewEmployee = async (data: any) => {
  const response = await $fetch(`${API_BASE_URL}/api/employees`, {
    method: "POST",
    body: data,
    headers: {
      Accept: "application/json",
    },
  });
  return response;
};


const onSubmit = async () => {
  if (!validateForm()) {
    return;
  }
  try {
    const formData = new FormData();
    Object.keys(form).forEach((key) => {
      // @ts-ignore
      if (form[key]?.trim()) {
        formData.append(key, form[key as never]);
      }
    });

    isSubmitting.value = true;
    const data = await addNewEmployee(formData);
    closeDrawer(false);
    emit("refresh-data");
  } catch (error) {
    console.log(error);
  } finally {
    isSubmitting.value = false;
  }
};


onMounted(() => {
  if (props.employee) {
    Object.keys(form).forEach((key) => {
      // @ts-ignore
      form[key] = props.employee[key] || "";
    });
  }
});


const editEmployee = async () => {
  if (!validateForm()) return;
  try {
    const formData = new FormData();
    Object.keys(form).forEach((key) => {
      // @ts-ignore
      if (form[key]) {
        formData.append(key, form[key as never]);
      }
    });

    isSubmitting.value = true;
    const resp = await $fetch(`${API_BASE_URL}/api/employees/${props?.employee?.id}`, {
      method: "POST",
      body: formData,
    });
    closeDrawer(false);
    emit("refresh-data");
  } catch (error) {
    console.log(error);
  } finally {
    isSubmitting.value = false;
  };
};

const closeDrawer = (openState: boolean) => {
  emit("update:open", openState);

  if (!openState && !props.employee) {
    Object.keys(form).forEach((key) => {
      // @ts-ignore
      form[key] = "";
    });
    errors.value = {};
  }
};


const handleSubmit = () => {
  if (!validateForm()) {
    return;
  }

  if (props.employee?.id) {
    editEmployee();
  } else {
    onSubmit();
  }
};

const mode = computed(() => (props.employee?.id ? "Editar" : "Cadastrar"));

const errors = ref<Record<string, string>>({});

const validateForm = () => {
  errors.value = {};
  if (!form.code.trim()) errors.value.code = "O código é obrigatório.";
  if (!form.full_name.trim()) errors.value.full_name = "O nome completo é obrigatório.";
  if (!form.user_name.trim()) errors.value.user_name = "O nome de usuário é obrigatório.";
  if (!form.document.trim()) errors.value.document = "O CPF é obrigatório.";
  if (!form.date_birth.trim()) errors.value.date_birth = "A data de nascimento é obrigatória.";
  if (!form.mother_name.trim()) errors.value.mother_name = "O nome da mãe é obrigatório.";
  if (!form.role.trim()) errors.value.role = "O cargo é obrigatório.";
  return Object.keys(errors.value).length === 0;
};
</script>


<template>
  <Sheet :open="open" @update:open="closeDrawer">
    <SheetContent class="w-full bg-white">
      <SheetHeader>
        <SheetTitle>{{ mode }}</SheetTitle>
        <SheetDescription>
          <template v-if="props.employee?.id">
            Faça alterações no perfil do funcionário aqui. Clique em salvar ao finalizar.
          </template>
          <template v-else>
            Preencha os dados para cadastrar um novo funcionário. Clique em salvar ao finalizar.
          </template>
        </SheetDescription>
      </SheetHeader>
      <div class="grid gap-4 py-4">
        <!-- Código -->
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="code" class="text-right">Código *</Label>
          <Input v-model="form.code" :errorMessage="errors.code" id="code" type="text" class="col-span-3" required />
        </div>

        <!-- Nome Completo -->
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="full_name" class="text-right">Nome Completo *</Label>
          <Input v-model="form.full_name" :errorMessage="errors.full_name" id="full_name" type="text" class="col-span-3"
            required />
        </div>

        <!-- Nome de Usuário -->
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="user_name" class="text-right">Usuário *</Label>
          <Input v-model="form.user_name" :errorMessage="errors.user_name" id="user_name" type="text" class="col-span-3"
            required />
        </div>

        <!-- CPF -->
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="document" class="text-right">CPF *</Label>
          <Input v-model="form.document" :errorMessage="errors.document" id="document" type="text" class="col-span-3"
            required />
        </div>

        <!-- Data de Nascimento -->
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="date_birth" class="text-right">Data de Nascimento *</Label>
          <Input v-model="form.date_birth" :errorMessage="errors.date_birth" id="date_birth" type="date"
            class="col-span-3" required />
        </div>

        <!-- Nome da Mãe -->
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="mother_name" class="text-right">Nome da Mãe *</Label>
          <Input v-model="form.mother_name" :errorMessage="errors.mother_name" id="mother_name" type="text"
            class="col-span-3" required />
        </div>

        <!-- Nome do Pai -->
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="father_name" class="text-right">Nome do Pai</Label>
          <Input v-model="form.father_name" id="father_name" type="text" class="col-span-3" />
        </div>

        <!-- Cargo -->
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="role" class="text-right">Cargo</Label>
          <Input v-model="form.role" :errorMessage="errors.role" id="role" type="text" class="col-span-3" />
        </div>
      </div>
      <SheetFooter>
        <Button type="submit" @click="handleSubmit">
          <template v-if="isSubmitting">Saving...</template>
          <template v-else> Salvar </template>
        </Button>
      </SheetFooter>
    </SheetContent>
  </Sheet>
</template>