<script setup>
import {
    Table,
    TableHead,
    TableHeadCell,
    TableBody,
    TableRow,
    TableCell,
    TheCard,
} from 'flowbite-vue';
import ActionsTable from '@/Components/General/ActionsTable.vue';
import ModalNormal from '@/Components/Modal/ModalNormal.vue';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const openModal = (id) => {
    dogBreedToDelete.value = id;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const goToEdit = (id) => {
    router.visit(route('dogs_breed.edit', id));
};

const handleOk = () => {
    router.delete(route('dogs_breed.destroy', dogBreedToDelete.value), {
        onFinish: () => showModal.value = false,
    });
};

const dogBreedToDelete = ref(0);
const showModal = ref(false);

defineProps({
    dogsBreed: Array,
});
</script>

<template>
    <TheCard class="!max-w-full mt-4" variant="image">
        <ModalNormal @cancel="closeModal" title="Delete Dog Type"
            text="Are you sure to delete the dog type?" :show="showModal"
            @ok="handleOk"
        />
        <Table striped class="max-w-5xl">
            <TableHead class="text-center">
                <TableHeadCell>Name</TableHeadCell>
                <TableHeadCell>Actions</TableHeadCell>
            </TableHead>
            <TableBody>
                <TableRow v-for="(dog, ind) in dogsBreed" :key="ind" class="text-center">
                    <TableCell>{{ dog.name }}</TableCell>
                    <ActionsTable @delete="() => openModal(dog.id)"
                        @edit="() => goToEdit(dog.id)"
                    />
                </TableRow>
            </TableBody>
        </Table>
    </TheCard>
</template>
