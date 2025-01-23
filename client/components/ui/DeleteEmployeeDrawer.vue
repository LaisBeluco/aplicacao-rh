<script lang="ts" setup>
import {AlertDialog, AlertDialogContent, AlertDialogHeader, AlertDialogTitle, AlertDialogDescription, AlertDialogFooter, AlertDialogCancel, AlertDialogAction} from './alert-dialog';

const emit = defineEmits(["refresh-data", "update:open"]);
const props = defineProps<{ open: boolean; employee?: EmployeeProps }>();
</script>


<template>
 <AlertDialog
   :open="open"
   @update:open="(openState: boolean) => $emit('update:open', openState)"
 >
   <AlertDialogContent>
     <AlertDialogHeader>
       <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
       <AlertDialogDescription>
         This action cannot be undone. This will permanently delete your book
         and remove your data from the server.
       </AlertDialogDescription>
     </AlertDialogHeader>
     <AlertDialogFooter>
       <AlertDialogCancel @click="$emit('update:open', false)"
         >Cancel</AlertDialogCancel
       >
       <AlertDialogAction>Continue</AlertDialogAction>
     </AlertDialogFooter>
   </AlertDialogContent>
 </AlertDialog>
</template>