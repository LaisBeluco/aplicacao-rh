<script lang="ts" setup>
import {AlertDialog, AlertDialogContent, AlertDialogHeader, AlertDialogTitle, AlertDialogDescription, AlertDialogFooter, AlertDialogCancel, AlertDialogAction} from './alert-dialog';

const emit = defineEmits(["refresh-data", "update:open"]);
const props = defineProps<{ open: boolean; employee?: EmployeeProps }>();

const closeDialog = () => emit("update:open", false);

const deleteEmployee = async () => {
  await $fetch(`${API_BASE_URL}/api/employees/${props?.employee?.id}`, {
    method: "DELETE",
  });
  emit("refresh-data");
  window.location.reload();
};
</script>


<template>
  <AlertDialog :open="open" @update:open="(openState: boolean) => $emit('update:open', openState)">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Tem certeza de que deseja excluir?</AlertDialogTitle>
        <AlertDialogDescription>
          Essa ação não pode ser desfeita. O colaborador será permanentemente removido do sistema.
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel @click="$emit('update:open', false)">Cancelar</AlertDialogCancel>
        <AlertDialogAction @click="deleteEmployee">Excluir</AlertDialogAction>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>