<script setup lang="ts">
import type { EmployeeProps } from "@/utils/types";
import {Sheet, SheetDescription, SheetContent, SheetHeader, SheetFooter, SheetTitle} from "./sheet"
import Label from "./label/Label.vue"
import Input from "./input/Input.vue"


type PickedProps = "code" | "full_name" | "document" | "created_at" | "birth_date";
interface CustomEmployeeProps extends Pick<EmployeeProps, PickedProps> {
}


const props = defineProps<{ open: boolean; employee?: EmployeeProps }>();
const emit = defineEmits(["update:open", "refresh-data"]);


const isSubmitting = ref(false);
let form = reactive<CustomEmployeeProps>({
 code: "",
 full_name: "",
 document: "",
 birth_date: "",
 created_at: "",
});

const onSubmit = async () => {};


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
         <Label for="employeeName" class="text-right"> Nome do Colaborador </Label>
         <Input
           v-model:model-value="form.full_name"
           type="text"
           id="employeeName"
           class="col-span-3"
           required
         />
       </div>
       <div class="grid grid-cols-4 items-center gap-4">
         <Label for="document" class="text-right"> CPF </Label>
         <Input
           v-model:model-value="form.document"
           type="text"
           id="document"
           class="col-span-3"
           required
         />
       </div>
       <div class="grid grid-cols-4 items-center gap-4">
         <Label for="code" class="text-right"> Código </Label>
         <Input
           v-model:model-value="form.code"
           type="text"
           id="code"
           class="col-span-3"
           required
         />
       </div>
       <div class="grid grid-cols-4 items-center gap-4">
         <Label for="birth_date" class="text-right">
           Data de Nascimento
         </Label>
         <Input
           v-model:model-value="form.birth_date"
           type="date"
           id="birth_date"
           class="col-span-3"
           required
         />
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