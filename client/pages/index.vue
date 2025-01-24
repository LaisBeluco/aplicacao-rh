<template>
  <main class="bg-gray-50 p-6 min-h-screen">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <header class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
        <h1 class="text-3xl font-bold text-gray-800 text-center md:text-left">Colaboradores da Bruning</h1>
        <div class="flex gap-4">
          <button
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium shadow-md w-full md:w-auto"
            @click="fetchEmployees">
            Atualizar Lista
          </button>
          <button
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium shadow-md flex items-center gap-2 w-full md:w-auto"
            @click="toggleAddEmployeeDrawer">
            + Cadastrar
          </button>
        </div>
      </header>

      <!-- Carregando -->
      <div v-if="isLoading" class="flex justify-center items-center">
        <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
      </div>

      <!-- Lista de Colaboradores -->
      <div v-else class="bg-white shadow-md rounded-lg p-4 md:p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4 text-center md:text-left">Lista de Colaboradores</h2>

        <div v-if="employees.length === 0" class="text-center text-gray-500 italic">
          Nenhum colaborador encontrado.
        </div>

        <!-- Tabela para telas médias e grandes -->
        <div class="hidden md:block overflow-x-auto">
          <table class="min-w-full border-collapse">
            <!-- Cabeçalho -->
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
              <tr>
                <th class="p-4 text-left">Código</th>
                <th class="p-4 text-left">Nome</th>
                <th class="p-4 text-left">Usuário</th>
                <th class="p-4 text-left">Documento</th>
                <th class="p-4 text-left">Nascimento</th>
                <th class="p-4 text-center">Ações</th>
              </tr>
            </thead>
            <!-- Corpo -->
            <tbody>
              <tr v-for="employee in employees" :key="employee.id" class="border-t even:bg-gray-50 hover:bg-gray-100">
                <td class="p-4 text-gray-700">{{ employee.code }}</td>
                <td class="p-4 text-gray-700">{{ employee.full_name }}</td>
                <td class="p-4 text-gray-700">{{ employee.user_name }}</td>
                <td class="p-4 text-gray-700">{{ formataCPF(employee.document) }}</td>
                <td class="p-4 text-gray-700">{{ formatDate(employee.date_birth) }}</td>
                <td class="p-4 flex justify-center gap-2">
                  <button class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600"
                    @click="toggleEditEmployeeDrawer(employee)">
                    Editar
                  </button>
                  <button class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600"
                    @click="toggleDeleteDialog(employee)" variant="destructive">
                    Excluir
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Cards para telas pequenas -->
        <div class="block md:hidden">
          <div v-for="employee in employees" :key="employee.id" class="border rounded-lg p-4 mb-4 bg-gray-50 shadow-md">
            <div class="flex justify-between items-center">
              <div>
                <h3 class="text-lg font-semibold">{{ employee.full_name }}</h3>
                <p class="text-sm text-gray-600">Usuário: {{ employee.user_name }}</p>
                <p class="text-sm text-gray-600">Código: {{ employee.code }}</p>
              </div>
              <div class="flex gap-2">
                <button class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600"
                  @click="toggleEditEmployeeDrawer(employee)">
                  Editar
                </button>
                <button class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600"
                  @click="toggleDeleteDialog(employee)">
                  Excluir
                </button>
              </div>
            </div>
            <p class="text-sm text-gray-600 mt-2">Documento: {{ formataCPF(employee.document) }}</p>
            <p class="text-sm text-gray-600">Nascimento: {{ formatDate(employee.date_birth) }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Modais -->
    <EmployeeDrawerDialog v-if="isEmployeeDrawerOpen" :open="isEmployeeDrawerOpen"
      @update:open="(open: boolean) => (isEmployeeDrawerOpen = open)" :employee="currentEmployee"
      @refresh-data="fetchEmployees" />
    <DeleteEmployeeDrawerDialog v-if="isDeleteEmployeeDialogOpen" :open="isDeleteEmployeeDialogOpen"
      @update:open="(open: boolean) => (isDeleteEmployeeDialogOpen = open)" :employee="currentEmployee"
      @refresh-data="fetchEmployees" />
  </main>
</template>

<script lang="ts" setup>
import { ref, onMounted } from "vue";
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
  currentEmployee.value = {
    id: 0,
    code: '',
    full_name: '',
    user_name: '',
    document: '',
    date_birth: '',
    mother_name: '',
    father_name: '',
    role: '',
  };
  isEmployeeDrawerOpen.value = true;
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
    employees.value = response.employees.data;
  } catch (error) {
    console.error(error);
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  fetchEmployees();
});
</script>
