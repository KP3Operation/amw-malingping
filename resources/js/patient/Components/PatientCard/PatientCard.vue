<script setup>
import { calculateAge, convertDateTimeToDate } from "@shared/utils/helpers";
import { toRefs } from "vue";
import Vue3Barcode from "vue3-barcode";
// export default defineComponent({
//   components: {
//     Vue3Barcode,
//   },
// })

const props = defineProps({
    name: String,
    medicalNo: String,
    gender: String,
    birthDate: String,
    isBarcode: {
        type: Boolean,
        default: false,
    },
    options: {
        type: Object,
        default: () => ({}),
    },
});

const { name, medicalNo, gender, birthDate } = toRefs(props);
</script>
<template>
    <div class="bg-blue-100 rounded p-3">
        <div class="d-flex col-gap-20">
            <div class="w-50">
                <p class="fs-6 text-gray-700">{{ $t("history.name") }}</p>
                <p class="fs-6 fw-semibold">{{ name }}</p>
            </div>

            <div class="w-50 text-end">
                <p class="fs-6 text-gray-700">{{ $t("history.medical_no") }}</p>
                <p class="fs-6 fw-semibold">{{ medicalNo }}</p>
            </div>
        </div>

        <div class="d-flex col-gap-20 mt-2">
            <div class="w-50">
                <p class="fs-6 text-gray-700">{{ $t("history.gender") }}</p>
                <p class="fs-6 fw-semibold mt-1">{{ gender }}</p>
            </div>

            <div class="w-50 text-end">
                <p class="fs-6 text-gray-700">{{ $t("history.birth_date") }}</p>
                <p class="fs-6 fw-semibold mt-1">
                    <span v-text="convertDateTimeToDate(birthDate)"></span
                    >&nbsp; (<span v-text="calculateAge(birthDate)"></span>
                    {{ $t("history.year") }})
                </p>
            </div>
        </div>
        <div
            class="d-flex col mt-3 justify-content-center"
            v-if="isBarcode == true"
            style="width: 100%"
        >
            <div class="barcode-wrapper">
                <Vue3Barcode
                    :value="medicalNo"
                    :options="{
                        format: 'CODE128',
                        lineColor: '#000000',
                        width: 2, // Lebar bar lebih besar agar barcode lebih jelas
                        height: 20, // Tinggi barcode agar proporsional dengan flex container
                        displayValue: true,
                    }"
                    style="width: 100%; max-width: 100%; height: auto"
                />
            </div>
        </div>
    </div>
</template>
