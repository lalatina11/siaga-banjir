<script lang="ts">
    import type { FloodAidItems } from '@/lib/types';
    import * as Table from '../../ui/table';
    interface Props {
        items: Array<FloodAidItems>;
    }
    let { items }: Props = $props();

    function priceToIDR(price: number) {
        return price.toLocaleString(undefined, {
            style: 'currency',
            currency: 'IDR',
        });
    }
    const totalPrice = $derived(
        items.reduce((acc, item) => acc + item.price, 0),
    );
</script>

<Table.Root>
    <Table.Caption>Daftar Bantuan</Table.Caption>
    <Table.Header>
        <Table.Row>
            <Table.Head class="w-[100px]">#</Table.Head>
            <Table.Head>Nama</Table.Head>
            <Table.Head>Harga</Table.Head>
        </Table.Row>
    </Table.Header>
    <Table.Body>
        {#each items as item, index (item.id)}
            <Table.Row>
                <Table.Cell class="font-medium">{index + 1}</Table.Cell>
                <Table.Cell>{item.name}</Table.Cell>
                <Table.Cell>{priceToIDR(item.price)}</Table.Cell>
            </Table.Row>
        {/each}
    </Table.Body>
    <Table.Footer>
        <Table.Row>
            <Table.Cell colspan={2}>Total</Table.Cell>
            <Table.Cell class="text-start">{priceToIDR(totalPrice)}</Table.Cell>
        </Table.Row>
    </Table.Footer>
</Table.Root>
