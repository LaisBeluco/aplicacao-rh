<script setup lang="ts">
import type { EmployeeProps } from "@/utils/types";
import { Sheet, SheetDescription, SheetContent, SheetHeader, SheetFooter, SheetTitle } from "./sheet"
import Label from "./label/Label.vue"
import Input from "./input/Input.vue"

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
  try {
    const formData = new FormData();
    Object.keys(form).forEach((key) => {
      // @ts-ignore
      if (form[key]) {
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


const closeDrawer = (openState: boolean) => emit("update:open", openState);
</script>


<template>
  <Sheet :open="open" @update:open="closeDrawer">
    <SheetContent class="w-full bg-white">
      <SheetHeader>
        <SheetTitle>
          <template v-if="employee"> Edit Book </template>
          <template v-else>Add New Book</template>
        </SheetTitle>
        <SheetDescription>
          Make changes to your profile here. Click save when you're done.
        </SheetDescription>
      </SheetHeader>
      <div class="grid gap-4 py-4">
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="code" class="text-right"> Código *</Label>
          <Input v-model:model-value="form.code" type="text" id="code" class="col-span-3" required />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="full_name" class="text-right"> Nome Completo *</Label>
          <Input v-model:model-value="form.full_name" type="text" id="full_name" class="col-span-3" required />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="user_name" class="text-right"> Usuário *</Label>
          <Input v-model:model-value="form.user_name" type="text" id="user_name" class="col-span-3" required />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="document" class="text-right"> CPF *</Label>
          <Input v-model:model-value="form.document" v-maska="'###.###.###-##'" type="text" id="document"
            class="col-span-3" required />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="date_birth" class="text-right">
            Data de Nascimento *
          </Label>
          <Input v-model:model-value="form.date_birth" v-mask="'##/##/####'" type="date" id="date_birth"
            class="col-span-3" required />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="mother_name" class="text-right"> Nome da Mãe *</Label>
          <Input v-model:model-value="form.mother_name" type="text" id="mother_name" class="col-span-3" required />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="father_name" class="text-right"> Nome do Pai </Label>
          <Input v-model:model-value="form.father_name" type="text" id="father_name" class="col-span-3" required />
        </div>
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="role" class="text-right"> Cargo </Label>
          <Input v-model:model-value="form.role" type="text" id="role" class="col-span-3" required />
        </div>
      </div>
      <SheetFooter>
        <Button type="submit" @click="onSubmit">
          <template v-if="isSubmitting">Saving...</template>
          <template v-else> Save changes </template>
        </Button>
      </SheetFooter>
    </SheetContent>
  </Sheet>
</template>