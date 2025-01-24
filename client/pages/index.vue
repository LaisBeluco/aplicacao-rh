<template>
  <main class="bg-white p-10 min-h-screen">
    <div class="max-w-4xl mx-auto">
      <header class="flex justify-between items-center mb-20">
        <h1 class="font-semibold text-4xl">Colaboradores da Bruning</h1>
        <div>
          <Button>Lista</Button>
          <Button @click="toggleAddEmployeeDrawer">Cadastrar</Button>
        </div>
      </header>

      <div v-if="isLoading">
        <p class="italic text-2xl font-medium text-center">Loading...</p>
      </div>
      <div class="mt-8">
        <h2 class="text-2xl font-bold mb-6">Lista de Colaboradores</h2>
        <div class="overflow-x-auto">
          <table class="min-w-full border-collapse border border-gray-300">
            <!-- Cabeçalho da Tabela -->
            <thead>
              <tr class="bg-gray-100">
                <th class="border border-gray-300 p-2 text-left">Código</th>
                <th class="border border-gray-300 p-2 text-left">Nome Completo</th>
                <th class="border border-gray-300 p-2 text-left">Usuário</th>
                <th class="border border-gray-300 p-2 text-left">Documento</th>
                <th class="border border-gray-300 p-2 text-left">Data de Nascimento</th>
                <th class="border border-gray-300 p-2 text-left">Ações</th>
              </tr>
            </thead>
            <!-- Corpo da Tabela -->
            <tbody>
              <tr v-for="employee in employees" :key="employee.id" class="even:bg-gray-50 hover:bg-gray-100">
                <td class="border border-gray-300 p-2">{{ employee.code }}</td>
                <td class="border border-gray-300 p-2">{{ employee.full_name }}</td>
                <td class="border border-gray-300 p-2">{{ employee.user_name }}</td>
                <td class="border border-gray-300 p-2">{{ formataCPF(employee.document) }}</td>
                <td class="border border-gray-300 p-2">{{ formatDate(employee.date_birth) }}</td>
                <td class="border border-gray-300 p-2 flex gap-2">
                  <Button @click="toggleEditEmployeeDrawer(employee)">Editar</Button>
                  <Button @click="toggleDeleteDialog(employee)" variant="destructive">
                    Excluir
                  </Button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <EmployeeDrawerDialog v-if="isEmployeeDrawerOpen" :open="isEmployeeDrawerOpen"
      @update:open="(open: boolean) => isEmployeeDrawerOpen = open" :employee="currentEmployee"
      @refresh-data="fetchEmployees" />
    <DeleteEmployeeDrawerDialog v-if="isDeleteEmployeeDialogOpen" :open="isDeleteEmployeeDialogOpen"
      @update:open="(open: boolean) => isDeleteEmployeeDialogOpen = open" :employee="currentEmployee"
      @refresh-data="fetchEmployees" />
  </main>
</template>


<script lang="ts" setup>
import { API_BASE_URL } from "@/utils/constants";
import type { EmployeeProps } from "@/utils/types";
import EmployeeDrawerDialog from "~/components/ui/EmployeeDrawer.vue";
import DeleteEmployeeDrawerDialog from "~/components/ui/DeleteEmployeeDrawer.vue";

const isLoading = ref(false);
const employees = ref<EmployeeProps[]>([]);

const currentEmployee = ref<EmployeeProps>();

const isEmployeeDrawerOpen = ref(false);
const isDeleteEmployeeDialogOpen = ref(false);


const toggleAddEmployeeDrawer = () => {
  isEmployeeDrawerOpen.value = !isEmployeeDrawerOpen.value;
};


const toggleEditEmployeeDrawer = (employee: EmployeeProps) => {
  currentEmployee.value = employee;
  isEmployeeDrawerOpen.value = !isEmployeeDrawerOpen.value;
};


const toggleDeleteDialog = (employee: EmployeeProps) => {
  currentEmployee.value = employee;
  isDeleteEmployeeDialogOpen.value = !isDeleteEmployeeDialogOpen.value;
};

const fetchEmployees = async () => {
  try {
    isLoading.value = true;
    const response = await $fetch<{ employees: EmployeeProps[] }>(
      `${API_BASE_URL}/api/employees`
    );

    employees.value = response.employees.data
  } catch (error) {
    console.log(error);
  } finally {
    isLoading.value = false;
  }
};


onMounted(() => {
  fetchEmployees();
});
</script>